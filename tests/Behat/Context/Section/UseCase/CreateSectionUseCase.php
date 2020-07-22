<?php

namespace App\Tests\Behat\Context\Section\UseCase;

use App\App\Command\Section\CreateSectionCommand;
use App\App\UseCase\Section\CreateSectionUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class CreateSectionUseCase implements Context
{
    /** @var SectionInterface */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateSectionCommand */
    private $createSectionCommand;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var CreateSectionUseCaseInterface */
    private $createSectionUseCase;

    /**
     * CreateSectionUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param CreateSectionUseCaseInterface $createSectionUseCase
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        CreateSectionUseCaseInterface $createSectionUseCase
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->createSectionUseCase = $createSectionUseCase;
    }

    /**
     * @Given I'm set CreateSectionCommandInterface
     */
    public function imSetCreatesectioncommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);

        $this->createSectionCommand = new CreateSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba229'),
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            'title'
        );

        $this->createSectionCommand->setCreatedAt(new DateTime());
        $this->createSectionCommand->setCreatedBy($user);
    }

    /**
     * @When I call method create
     */
    public function iCallMethodCreate()
    {
        $this->result = $this->createSectionUseCase->create($this->createSectionCommand);
    }

    /**
     * @Then I should get SectionInterface
     */
    public function iShouldGetSectioninterface()
    {
        Assert::assertTrue($this->result instanceof SectionInterface);
    }

    /**
     * @Then Section position need to be increased
     */
    public function sectionPositionNeedToBeIncreased()
    {
        /** @var int $latestPosition */
        $latestPosition =
            $this->sectionQueryRepository->getMaxPosition($this->createSectionCommand->getReportTemplateId());

        Assert::assertEquals(++$latestPosition, $this->result->getPosition());
    }

    /**
     * @Then Section printable field need to be true
     */
    public function sectionPrintableFieldNeedToBeTrue()
    {
        Assert::assertEquals(true, $this->result->isPrintable());
    }
}
