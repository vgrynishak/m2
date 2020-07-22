<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;

class GetByIdValidator extends BaseCommandValidator implements GetByIdValidatorInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;

    /**
     * GetByIdValidator constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     */
    public function __construct(ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository)
    {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
    }

    /**
     * @param GetByIdCommandInterface $command
     * @return bool
     */
    public function validate(GetByIdCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());

        if (!$reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report template was not found";
        }

        return $this->check();
    }
}
