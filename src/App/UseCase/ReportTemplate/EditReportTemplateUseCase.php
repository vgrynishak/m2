<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use DateTime;
use Exception;

class EditReportTemplateUseCase implements EditReportTemplateUseCaseInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;

    /**
     * EditReportTemplateUseCase constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     */
    public function __construct(ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository)
    {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
    }

    /**
     * @param EditReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     * @throws Exception
     */
    public function edit(EditReportTemplateCommandInterface $command): ReportTemplateInterface
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getReportTemplateId());

        $reportTemplate->setUpdatedAt(new DateTime());
        $reportTemplate->setModifiedBy($command->getModifiedBy());
        $reportTemplate->setName($command->getName());

        if ($command->getDescription()) {
            $reportTemplate->setDescription($command->getDescription());
        }

        return $reportTemplate;
    }
}
