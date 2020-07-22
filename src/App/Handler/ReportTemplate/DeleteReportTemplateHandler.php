<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\DeleteReportTemplateValidatorInterface;
use App\App\UseCase\ReportTemplate\DeleteReportTemplateUseCaseInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailDeleteReportTemplateAction;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Exception;

class DeleteReportTemplateHandler implements MessageHandlerInterface
{
    /** @var ReportTemplateCommandRepositoryInterface */
    protected $reportTemplateRepository;
    /** @var DeleteReportTemplateUseCaseInterface */
    private $deleteReportTemplateUseCase;
    /** @var DeleteReportTemplateValidatorInterface */
    private $deleteReportTemplateValidator;

    /**
     * DeleteReportTemplateHandler constructor.
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateRepository
     * @param DeleteReportTemplateUseCaseInterface $deleteReportTemplateUseCase
     * @param DeleteReportTemplateValidatorInterface $deleteReportTemplateValidator
     */
    public function __construct(
        ReportTemplateCommandRepositoryInterface $reportTemplateRepository,
        DeleteReportTemplateUseCaseInterface $deleteReportTemplateUseCase,
        DeleteReportTemplateValidatorInterface $deleteReportTemplateValidator
    ) {
        $this->reportTemplateRepository = $reportTemplateRepository;
        $this->deleteReportTemplateUseCase = $deleteReportTemplateUseCase;
        $this->deleteReportTemplateValidator = $deleteReportTemplateValidator;
    }

    /**
     * @param DeleteReportTemplateCommandInterface $command
     * @throws FailDeleteReportTemplateAction
     */
    public function __invoke(DeleteReportTemplateCommandInterface $command): void
    {
        if (!$this->deleteReportTemplateValidator->validate($command)) {
            throw new FailDeleteReportTemplateAction($this->deleteReportTemplateValidator->getFirstErrorMessage());
        }

        try {
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->deleteReportTemplateUseCase->delete($command);
            $this->reportTemplateRepository->update($reportTemplate);
        } catch (Exception $exception) {
            throw new FailDeleteReportTemplateAction("Bad request");
        }
    }
}
