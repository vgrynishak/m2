<?php

namespace App\Tests\Behat\Context\ReportTemplate\UseCase;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommand;
use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\App\UseCase\ReportTemplate\ArchiveReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ArchiveReportTemplateUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReportTemplateInterface */
    private $result;
    /** @var ArchiveReportTemplateCommandInterface */
    private $archiveReportTemplateCommand;
    /** @var ArchiveReportTemplateUseCaseInterface */
    private $archiveReportTemplateUseCase;

    /**
     * ArchiveReportTemplateUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ArchiveReportTemplateUseCaseInterface $archiveReportTemplateUseCase
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ArchiveReportTemplateUseCaseInterface $archiveReportTemplateUseCase
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->archiveReportTemplateUseCase = $archiveReportTemplateUseCase;
    }

    /**
     * @Given I'm set ArchiveReportTemplateCommandInterface with correct params
     */
    public function imSetArchivereporttemplatecommandinterfaceWithCorrectParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->archiveReportTemplateCommand = new ArchiveReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user
        );
    }

    /**
     * @When I call ArchiveReportTemplateUseCase
     */
    public function iCallArchivereporttemplateusecase()
    {
        $this->result = $this->archiveReportTemplateUseCase->archive($this->archiveReportTemplateCommand);
    }

    /**
     * @Then I should get ReportTemplateInterface with archived params
     */
    public function iShouldGetReporttemplateinterfaceWithArchivedParams()
    {
        if (!$this->result instanceof ReportTemplateInterface) {
            return false;
        }
        Assert::assertEquals($this->result->getStatus()->getId(), ReportTemplateStatus::ARCHIVED);
        Assert::assertEquals($this->result->getModifiedBy(), $this->archiveReportTemplateCommand->getModifiedBy());
    }
}
