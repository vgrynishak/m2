<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommand;
use App\App\Command\ReportTemplate\Validator\ArchiveReportTemplateValidatorInterface;
use App\App\UseCase\ReportTemplate\ArchiveReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailArchiveReportTemplateAction;
use Exception;

class ArchiveReportTemplateHandler
{
    /** @var ReportTemplateCommandRepositoryInterface */
    private $reportTemplateCommandRepository;
    /** @var ArchiveReportTemplateValidatorInterface */
    private $archiveReportTemplateValidator;
    /** @var ArchiveReportTemplateUseCaseInterface */
    private $archiveReportTemplateUseCase;

    /**
     * ArchiveReportTemplateHandler constructor.
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository
     * @param ArchiveReportTemplateValidatorInterface $archiveReportTemplateValidator
     * @param ArchiveReportTemplateUseCaseInterface $archiveReportTemplateUseCase
     */
    public function __construct(
        ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository,
        ArchiveReportTemplateValidatorInterface $archiveReportTemplateValidator,
        ArchiveReportTemplateUseCaseInterface $archiveReportTemplateUseCase
    ) {
        $this->reportTemplateCommandRepository = $reportTemplateCommandRepository;
        $this->archiveReportTemplateValidator = $archiveReportTemplateValidator;
        $this->archiveReportTemplateUseCase = $archiveReportTemplateUseCase;
    }

    /**
     * @param ArchiveReportTemplateCommand $command
     * @throws FailArchiveReportTemplateAction
     */
    public function __invoke(ArchiveReportTemplateCommand $command): void
    {
        if (!$this->archiveReportTemplateValidator->validate($command)) {
            throw new FailArchiveReportTemplateAction(
                $this->archiveReportTemplateValidator->getFirstErrorMessage()
            );
        }

        try {
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->archiveReportTemplateUseCase->archive($command);

            $this->reportTemplateCommandRepository->update($reportTemplate);
        } catch (Exception $exception) {
            throw new FailArchiveReportTemplateAction($exception->getMessage());
        }
    }
}
