<?php

namespace App\Tests\Behat\Context\ReportTemplate\UseCase;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommand;
use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\UseCase\ReportTemplate\DeleteReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class DeleteReportTemplateUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var ReportTemplateInterface */
    private $result;
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeleteReportTemplateUseCaseInterface */
    private $deleteReportTemplateUseCase;
    /** @var DeleteReportTemplateCommandInterface */
    private $deleteReportTemplateCommand;

    /**
     * DeleteReportTemplateUseCase constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeleteReportTemplateUseCaseInterface $deleteReportTemplateUseCase
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository,
        DeleteReportTemplateUseCaseInterface $deleteReportTemplateUseCase
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
        $this->deleteReportTemplateUseCase = $deleteReportTemplateUseCase;
    }


    /**
     * @Given I'm set DeleteReportTemplateCommandInterface with correct params
     */
    public function imSetDeletereporttemplatecommandinterfaceWithCorrectParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->deleteReportTemplateCommand = new DeleteReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user
        );
    }

    /**
     * @When I call DeleteReportTemplateUseCase
     */
    public function iCallDeletereporttemplateusecase()
    {
        $this->result = $this->deleteReportTemplateUseCase->delete($this->deleteReportTemplateCommand);
    }

    /**
     * @Then I should get ReportTemplateInterface with correct deleted params
     */
    public function iShouldGetReporttemplateinterfaceWithCorrectDeletedParams()
    {
        if (!$this->result instanceof ReportTemplateInterface) {
            return false;
        }
        Assert::assertEquals($this->result->getStatus()->getId(), ReportTemplateStatus::DELETED);
        Assert::assertEquals($this->result->getModifiedBy(), $this->deleteReportTemplateCommand->getUser());
    }
}
