<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use DateTime;
use Exception;

class ArchiveReportTemplateUseCase implements ArchiveReportTemplateUseCaseInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * ArchiveReportTemplateUseCase constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
    }

    /**
     * @param ArchiveReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     * @throws Exception
     */
    public function archive(ArchiveReportTemplateCommandInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());

        /** @var ReportTemplateStatus $statusArchived */
        $statusArchived = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::ARCHIVED);
        $reportTemplate->setStatus($statusArchived);

        $reportTemplate->setUpdatedAt(new DateTime());
        $reportTemplate->setModifiedBy($command->getModifiedBy());

        return $reportTemplate;
    }
}