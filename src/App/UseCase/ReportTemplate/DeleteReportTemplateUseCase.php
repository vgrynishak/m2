<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use DateTime;
use Exception;

class DeleteReportTemplateUseCase implements DeleteReportTemplateUseCaseInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * DeleteReportTemplateUseCase constructor.
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
     * @param DeleteReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     * @throws Exception
     */
    public function delete(DeleteReportTemplateCommandInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());

        /** @var ReportTemplateStatus $statusDeleted */
        $statusDeleted = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::DELETED);
        $reportTemplate->setStatus($statusDeleted);

        $reportTemplate->setUpdatedAt(new DateTime());
        $reportTemplate->setModifiedBy($command->getUser());

        return $reportTemplate;
    }
}
