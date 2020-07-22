<?php

namespace App\Tests\Behat\Context\Section\UseCase;

use App\App\Command\Section\DeleteSectionCommand;
use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Doctrine\Entity\Section as SectionEntity;
use App\App\Doctrine\Repository\SectionRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\UseCase\Section\DeleteSectionUseCaseInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class DeleteSectionUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeleteSectionCommandInterface */
    private $deleteSectionCommand;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;
    /** @var Connection */
    private $doctrineConnection;
    /** @var SectionInterface */
    private $section;
    /** @var SectionEntity[] */
    private $sectionListState;
    /** @var SectionRepository */
    private $sectionRepository;
    /** @var DeleteSectionUseCaseInterface */
    private $deleteSectionUseCase;
    /** @var SectionEntity[] */
    private $sectionList;

    /**
     * DeleteSectionUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param UserRepository $userRepository
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     * @param Connection $doctrineConnection
     * @param DeleteSectionUseCaseInterface $deleteSectionUseCase
     * @param SectionRepository $sectionRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        UserRepository $userRepository,
        SectionCommandRepositoryInterface $sectionCommandRepository,
        Connection $doctrineConnection,
        DeleteSectionUseCaseInterface $deleteSectionUseCase,
        SectionRepository $sectionRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->userRepository = $userRepository;
        $this->sectionCommandRepository = $sectionCommandRepository;
        $this->doctrineConnection = $doctrineConnection;
        $this->deleteSectionUseCase = $deleteSectionUseCase;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @Given I'm set DeleteSectionCommandInterface
     */
    public function imSetDeletesectioncommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->deleteSectionCommand = new DeleteSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba225'),
            $user
        );
    }

    /**
     * @Given Find Section which I want to delete
     */
    public function findSectionWhichIWantToDelete()
    {
        $this->section = $this->sectionQueryRepository->find($this->deleteSectionCommand->getId());
    }

    /**
     * @Given Find Section List which need to be decreased after delete action
     */
    public function findSectionListWhichNeedToBeDecreasedAfterDeleteAction()
    {
        /** @var int $maxCurrentPosition */
        $maxCurrentPosition = $this->sectionQueryRepository->getMaxPosition($this->section->getReportTemplateId());

        $sectionListState =
            $this->sectionRepository->getListWhoNeedDecreaseInPosition($this->section, $maxCurrentPosition);

        /** @var SectionEntity $sectionState */
        foreach ($sectionListState as $sectionState) {
            $this->sectionListState[$sectionState->getId()] = $sectionState->getPosition();
        }
    }

    /**
     * @throws ConnectionException
     *
     * @When I call method delete
     */
    public function iCallMethodDelete()
    {
        $this->doctrineConnection->beginTransaction();

        $this->deleteSectionUseCase->delete($this->deleteSectionCommand);
        $this->section = $this->sectionQueryRepository->find($this->deleteSectionCommand->getId());

        foreach ($this->sectionListState as $sectionId => $sectionPosition) {
            $this->sectionList[] = $this->sectionRepository->findOneBy(['id' => $sectionId]);
        }

        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then Predefined section list need to be decreased
     */
    public function predefinedSectionListNeedToBeDecreased()
    {
        /** @var bool $result */
        $result = true;

        /** @var SectionEntity $sectionEntity */
        foreach ($this->sectionList as $sectionEntity) {
            /** @var int $currentSectionPosition */
            $currentSectionPosition = $sectionEntity->getPosition();
            /** @var int $stateSectionPosition */
            $stateSectionPosition = $this->sectionListState[$sectionEntity->getId()];

            if ($stateSectionPosition - $currentSectionPosition != 1) {
                $result = false;
            }
        }

        Assert::assertEquals($result, true);
    }

    /**
     * @Then Predefined Section need to be deleted
     */
    public function predefinedSectionNeedToBeDeleted()
    {
        Assert::assertEquals(!$this->section instanceof SectionInterface, true);
    }
}
