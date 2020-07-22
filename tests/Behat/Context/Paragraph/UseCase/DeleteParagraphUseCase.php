<?php

namespace App\Tests\Behat\Context\Paragraph\UseCase;

use App\App\Command\Paragraph\DeleteParagraphCommand;
use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Doctrine\Entity\Paragraph as ParagraphEntity;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\UseCase\Paragraph\DeleteParagraphUseCaseInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class DeleteParagraphUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeleteParagraphCommandInterface */
    private $deleteParagraphCommand;
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;
    /** @var Connection */
    private $doctrineConnection;
    /** @var BaseParagraphInterface */
    private $paragraph;
    /** @var ParagraphEntity[] */
    private $paragraphListState;
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var DeleteParagraphUseCaseInterface */
    private $deleteParagraphUseCase;
    /** @var ParagraphEntity[] */
    private $paragraphList;

    /**
     * DeleteParagraphUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param UserRepository $userRepository
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     * @param Connection $doctrineConnection
     * @param DeleteParagraphUseCaseInterface $deleteParagraphUseCase
     * @param ParagraphRepository $paragraphRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        UserRepository $userRepository,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository,
        Connection $doctrineConnection,
        DeleteParagraphUseCaseInterface $deleteParagraphUseCase,
        ParagraphRepository $paragraphRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->userRepository = $userRepository;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
        $this->doctrineConnection = $doctrineConnection;
        $this->deleteParagraphUseCase = $deleteParagraphUseCase;
        $this->paragraphRepository = $paragraphRepository;
    }

    /**
     * @Given I'm set DeleteParagraphCommandInterface
     */
    public function imSetDeleteparagraphcommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->deleteParagraphCommand = new DeleteParagraphCommand(
            new ParagraphId('63bea125-46f1-4d59-b6ec-13008d13ac9f'),
            $user
        );
    }

    /**
     * @Given Find Paragraph which I want to delete
     */
    public function findParagraphWhichIWantToDelete()
    {
        $this->paragraph = $this->paragraphQueryRepository->find($this->deleteParagraphCommand->getId());
    }

    /**
     * @Given Find Paragraph List which need to be decreased after delete action
     */
    public function findParagraphListWhichNeedToBeDecreasedAfterDeleteAction()
    {
        /** @var int $maxCurrentPosition */
        $maxCurrentPosition = $this->paragraphQueryRepository->getMaxPosition($this->paragraph);

        $paragraphListState =
            $this->paragraphRepository->getListWhoNeedDecreaseInPosition($this->paragraph, $maxCurrentPosition);

        /** @var ParagraphEntity $paragraphState */
        foreach ($paragraphListState as $paragraphState) {
            $this->paragraphListState[$paragraphState->getId()] = $paragraphState->getPosition();
        }
    }

    /**
     * @throws ConnectionException
     * @When I call method delete
     */
    public function iCallMethodDelete()
    {
        $this->doctrineConnection->beginTransaction();

        $this->deleteParagraphUseCase->delete($this->deleteParagraphCommand);
        $this->paragraph = $this->paragraphQueryRepository->find($this->deleteParagraphCommand->getId());

        foreach ($this->paragraphListState as $paragraphId => $paragraphPosition) {
            $this->paragraphList[] = $this->paragraphRepository->findOneBy(['id' => $paragraphId]);
        }

        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then Predefined paragraph list need to be decreased
     */
    public function predefinedParagraphListNeedToBeDecreased()
    {
        /** @var bool $result */
        $result = true;

        /** @var ParagraphEntity $paragraphEntity */
        foreach ($this->paragraphList as $paragraphEntity) {
            /** @var int $currentParagraphPosition */
            $currentParagraphPosition = $paragraphEntity->getPosition();
            /** @var int $stateParagraphPosition */
            $stateParagraphPosition = $this->paragraphListState[$paragraphEntity->getId()];

            if ($stateParagraphPosition - $currentParagraphPosition != 1) {
                $result = false;
            }
        }

        Assert::assertEquals($result, true);
    }

    /**
     * @Then Predefined Paragraph need to be deleted
     */
    public function predefinedParagraphNeedToBeDeleted()
    {
        Assert::assertEquals(!$this->paragraph instanceof BaseParagraphInterface, true);
    }
}
