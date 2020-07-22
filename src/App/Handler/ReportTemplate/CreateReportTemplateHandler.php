<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\CreateReportTemplateValidatorInterface;
use App\App\Mapper\ReportTemplate\CreateReportTemplateCommandMapperInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Infrastructure\Exception\ReportTemplate\FailCreateReportTemplateAction;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class CreateReportTemplateHandler
{
    /** @var ReportTemplateCommandRepositoryInterface */
    private $reportTemplateRepository;
    /** @var ManagerRegistry */
    private $registry;
    /** @var CreateReportTemplateCommandMapperInterface */
    private $reportTemplateMapper;
    /** @var CreateReportTemplateValidatorInterface */
    private $createReportTemplateValidator;

    /**
     * CreateReportTemplateHandler constructor.
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateRepository
     * @param ManagerRegistry $registry
     * @param CreateReportTemplateCommandMapperInterface $reportTemplateMapper
     * @param CreateReportTemplateValidatorInterface $createReportTemplateValidator
     */
    public function __construct(
        ReportTemplateCommandRepositoryInterface $reportTemplateRepository,
        ManagerRegistry $registry,
        CreateReportTemplateCommandMapperInterface $reportTemplateMapper,
        CreateReportTemplateValidatorInterface $createReportTemplateValidator
    ) {
        $this->reportTemplateRepository = $reportTemplateRepository;
        $this->registry = $registry;
        $this->reportTemplateMapper = $reportTemplateMapper;
        $this->createReportTemplateValidator = $createReportTemplateValidator;
    }

    /**
     * @param CreateReportTemplateCommandInterface $command
     * @throws FailCreateReportTemplateAction
     */
    public function __invoke(CreateReportTemplateCommandInterface $command)
    {
        if (!$this->createReportTemplateValidator->validate($command)) {
            throw new FailCreateReportTemplateAction($this->createReportTemplateValidator->getFirstErrorMessage());
        }

        try {
            /** @var ReportTemplateInterface $reportTemplate */
            $reportTemplate = $this->reportTemplateMapper->map($command);
            $this->reportTemplateRepository->create($reportTemplate);
        } catch (Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
