<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class ArchiveReportTemplateValidator extends BaseCommandValidator implements ArchiveReportTemplateValidatorInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReportTemplateStatusQueryRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * ArchiveReportTemplateValidator constructor.
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
     * @param ArchiveReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(ArchiveReportTemplateCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());
        /** @var ReportTemplateStatusInterface $statusArchived */
        $statusArchived = $this->reportTemplateStatusQueryRepository->find(ReportTemplateStatus::ARCHIVED);

        if (!$reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report Template is not found";
        }

        if (!$statusArchived instanceof ReportTemplateStatusInterface) {
            $this->errors[] = "Status: " . ReportTemplateStatus::ARCHIVED . 'was not found';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User is not found";
        }

        return $this->check();
    }
}
