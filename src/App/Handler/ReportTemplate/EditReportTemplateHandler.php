<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\EditReportTemplateCommand;
use App\App\Command\ReportTemplate\Validator\EditReportTemplateValidatorInterface;
use App\App\UseCase\ReportTemplate\EditReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailEditReportTemplateAction;
use Exception;

class EditReportTemplateHandler
{
    /** @var ReportTemplateCommandRepositoryInterface */
    private $reportTemplateCommandRepository;
    /** @var EditReportTemplateValidatorInterface */
    private $editReportTemplateCommandValidator;
    /** @var EditReportTemplateUseCaseInterface */
    private $editReportTemplateUseCase;

    /**
     * EditReportTemplateHandler constructor.
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository
     * @param EditReportTemplateValidatorInterface $editReportTemplateCommandValidator
     * @param EditReportTemplateUseCaseInterface $editReportTemplateUseCase
     */
    public function __construct(
        ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository,
        EditReportTemplateValidatorInterface $editReportTemplateCommandValidator,
        EditReportTemplateUseCaseInterface $editReportTemplateUseCase
    ) {
        $this->reportTemplateCommandRepository = $reportTemplateCommandRepository;
        $this->editReportTemplateCommandValidator = $editReportTemplateCommandValidator;
        $this->editReportTemplateUseCase = $editReportTemplateUseCase;
    }

    /**
     * @param EditReportTemplateCommand $command
     * @throws FailEditReportTemplateAction
     */
    public function __invoke(EditReportTemplateCommand $command): void
    {
        try {
            if (!$this->editReportTemplateCommandValidator->validate($command)) {
                throw new FailEditReportTemplateAction(
                    $this->editReportTemplateCommandValidator->getFirstErrorMessage()
                );
            }
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->editReportTemplateUseCase->edit($command);

            $this->reportTemplateCommandRepository->update($reportTemplate);
        } catch (Exception $exception) {
            throw new FailEditReportTemplateAction($exception->getMessage());
        }
    }
}
