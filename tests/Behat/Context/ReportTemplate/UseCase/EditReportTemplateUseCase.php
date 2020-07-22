<?php

namespace App\Tests\Behat\Context\ReportTemplate\UseCase;

use App\App\Command\ReportTemplate\EditReportTemplateCommand;
use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\UseCase\ReportTemplate\EditReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class EditReportTemplateUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var ReportTemplateInterface */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var EditReportTemplateCommandInterface */
    private $editReportTemplateCommand;
    /** @var EditReportTemplateUseCaseInterface */
    private $editReportTemplateUseCase;

    /**
     * EditReportTemplateUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param EditReportTemplateUseCaseInterface $editReportTemplateUseCase
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        EditReportTemplateUseCaseInterface $editReportTemplateUseCase
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->editReportTemplateUseCase = $editReportTemplateUseCase;
    }

    /**
     * @Given I'm set EditReportTemplateCommandInterface with correct params
     */
    public function imSetEditreporttemplatecommandinterfaceWithCorrectParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->editReportTemplateCommand = new EditReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user,
            'new_name'
        );
        $this->editReportTemplateCommand->setDescription("test_description");
    }

    /**
     * @When I call EditReportTemplateUseCase
     */
    public function iCallEditreporttemplateusecase()
    {
        $this->result = $this->editReportTemplateUseCase->edit($this->editReportTemplateCommand);
    }

    /**
     * @Then I should get ReportTemplateInterface with edited params
     */
    public function iShouldGetReporttemplateinterfaceWithEditedParams()
    {
        if (!$this->result instanceof ReportTemplateInterface) {
            return false;
        }
        Assert::assertEquals($this->result->getName(), $this->editReportTemplateCommand->getName());
        Assert::assertEquals($this->result->getModifiedBy(), $this->editReportTemplateCommand->getModifiedBy());
        Assert::assertEquals($this->result->getDescription(), $this->editReportTemplateCommand->getDescription());
    }
}
