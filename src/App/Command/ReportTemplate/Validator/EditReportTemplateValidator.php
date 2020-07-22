<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\EditReportTemplateValidatorInterface as EditRTValidatorInterface;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class EditReportTemplateValidator extends BaseCommandValidator implements EditRTValidatorInterface
{
    /** @var string */
    public $message = '';
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateCommandRepositoryInterface */
    private $reportTemplateRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * EditReportTemplateCommandValidator constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param ReportTemplateCommandRepositoryInterface $reportTemplateRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        ReportTemplateCommandRepositoryInterface $reportTemplateRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->reportTemplateRepository = $reportTemplateRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param EditReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(EditReportTemplateCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getReportTemplateId());

        if (!$reportTemplate instanceof ReportTemplate) {
            $this->errors[] = 'Report template was not found';
        }

        if ($reportTemplate instanceof ReportTemplateInterface) {
            if ($reportTemplate->getStatus() and $reportTemplate->getStatus()->getId() != ReportTemplateStatus::DRAFT) {
                $this->errors[] = 'Invalid Report template status';
            }
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "Modified User was not found";
        }

        if (strlen($command->getName()) < 3) {
            $this->errors[] = "Report Template name can not be less that 3";
        }

        if ($command->getDescription()) {
            if (strlen($command->getDescription()) < 3) {
                $this->errors[] = "Report Template description can not be less that 3";
            }
        }

        return $this->check();
    }
}
