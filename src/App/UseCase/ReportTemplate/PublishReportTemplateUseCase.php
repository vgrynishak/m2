<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use DateTime;
use Exception;

class PublishReportTemplateUseCase implements PublishReportTemplateUseCaseInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateCommandRepositoryInterface */
    private $reportTemplateCommandRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * PublishReportTemplateUseCase constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository,
        ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->reportTemplateCommandRepository = $reportTemplateCommandRepository;
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
    }

    /**
     * @param PublishReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     * @throws Exception
     */
    public function publish(PublishReportTemplateCommandInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());
        /** @var ReportTemplateStatusInterface $statusDeleted */
        $statusPublished = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::PUBLISHED);

        $reportTemplate->setStatus($statusPublished);
        $reportTemplate->setUpdatedAt(new DateTime());
        $reportTemplate->setModifiedBy($command->getUser());

        return $reportTemplate;
    }
}
