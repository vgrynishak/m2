<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\PublishReportTemplateValidatorInterface;
use App\App\UseCase\ReportTemplate\PublishReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailPublishReportTemplateAction;
use Exception;

class PublishReportTemplateHandler
{
    /** @var PublishReportTemplateValidatorInterface */
    private $publishReportTemplateValidator;
    /** @var PublishReportTemplateUseCaseInterface */
    private $publishReportTemplateUseCase;
    /** @var ReportTemplateCommandRepositoryInterface */
    protected $reportTemplateCommandRepository;

    /**
     * PublishReportTemplateHandler constructor.
     * @param PublishReportTemplateValidatorInterface $publishReportTemplateValidator
     * @param PublishReportTemplateUseCaseInterface $publishReportTemplateUseCase
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository
     */
    public function __construct(
        PublishReportTemplateValidatorInterface $publishReportTemplateValidator,
        PublishReportTemplateUseCaseInterface $publishReportTemplateUseCase,
        ReportTemplateCommandRepositoryInterface $reportTemplateCommandRepository
    ) {
        $this->publishReportTemplateValidator = $publishReportTemplateValidator;
        $this->publishReportTemplateUseCase = $publishReportTemplateUseCase;
        $this->reportTemplateCommandRepository = $reportTemplateCommandRepository;
    }

    /**
     * @param PublishReportTemplateCommandInterface $command
     * @throws FailPublishReportTemplateAction
     */
    public function __invoke(PublishReportTemplateCommandInterface $command)
    {
        if (!$this->publishReportTemplateValidator->validate($command)) {
            throw new FailPublishReportTemplateAction(
                $this->publishReportTemplateValidator->getFirstErrorMessage()
            );
        }

        try {
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->publishReportTemplateUseCase->publish($command);

            $this->reportTemplateCommandRepository->update($reportTemplate);
        } catch (Exception $exception) {
            throw new FailPublishReportTemplateAction($exception->getMessage());
        }
    }
}
