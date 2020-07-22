<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class PublishReportTemplateValidator extends BaseCommandValidator implements PublishReportTemplateValidatorInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * PublishReportTemplateValidator constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository,
        ReportTemplateStatusQueryRepositoryInterface $reportTemplateStatusQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
        $this->reportTemplateStatusQueryRepository = $reportTemplateStatusQueryRepository;
    }

    /**
     * @param PublishReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(PublishReportTemplateCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());
        /** @var ReportTemplateStatusInterface $statusDeleted */
        $statusPublished = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::PUBLISHED);

        if (!$reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report Template is not found";
        } else {
            /** @var ReportTemplateStatusInterface $reportTemplateStatusModel */
            $reportTemplateStatusModel = $reportTemplate->getStatus();

            if ($reportTemplateStatusModel->getId() != ReportTemplateStatus::DRAFT
                and $reportTemplateStatusModel->getId() != ReportTemplateStatus::ARCHIVED
            ) {
                $this->errors[] = "Report Template has unavailable status";
            }
        }

        if (!$statusPublished instanceof ReportTemplateStatusInterface) {
            $this->errors[] = "Status: " . ReportTemplateStatus::PUBLISHED . 'was not found';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getUser()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User is not found";
        }

        return $this->check();
    }
}
