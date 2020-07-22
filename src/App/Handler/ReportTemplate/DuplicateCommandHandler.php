<?php

namespace App\App\Handler\ReportTemplate;

use App\App\Command\ReportTemplate\DuplicateCommand;
use App\App\Mapper\Exception\EntityNotFound;
use App\App\UseCase\ReportTemplate\Duplicate;
use App\Core\Model\ReportTemplate\ReportTemplate as ReportTemplateModel;
use App\Infrastructure\Exception\ReportTemplate\FailDuplicateAction;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use Exception;

class DuplicateCommandHandler implements MessageHandlerInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    protected $reportTemplateQueryRepository;
    /** @var ReportTemplateCommandRepositoryInterface */
    protected $reportTemplateRepository;
    /** @var Duplicate */
    private $duplicateRt;

    /**
     * DuplicateCommandHandler constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateRepository
     * @param Duplicate $duplicateRt
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        ReportTemplateCommandRepositoryInterface $reportTemplateRepository,
        Duplicate $duplicateRt
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->reportTemplateRepository = $reportTemplateRepository;
        $this->duplicateRt = $duplicateRt;
    }

    /**
     * @param DuplicateCommand $duplicateByIdCommand
     * @return mixed
     * @throws FailDuplicateAction
     */
    public function __invoke(DuplicateCommand $duplicateByIdCommand)
    {
        try {
            /** @var ReportTemplateModel $reportTemplate */
            $reportTemplate = $this->reportTemplateQueryRepository->find($duplicateByIdCommand->getId());
            if (!$reportTemplate instanceof ReportTemplateModel) {
                throw new EntityNotFound("ReportTemplate entity not found");
            }

            /** @var ReportTemplateModel $duplicatedReportTemplate */
            $duplicatedReportTemplate = $this->duplicateRt->duplicate(
                $reportTemplate,
                $duplicateByIdCommand->getUser()
            );

            return $this->reportTemplateRepository->create($duplicatedReportTemplate);
        } catch (Exception $exception) {
            throw new FailDuplicateAction($exception->getMessage());
        }
    }
}
