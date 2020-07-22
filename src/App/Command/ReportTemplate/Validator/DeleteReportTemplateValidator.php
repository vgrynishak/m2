<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class DeleteReportTemplateValidator extends BaseCommandValidator implements DeleteReportTemplateValidatorInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * DeleteReportTemplateValidator constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param DeleteReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(DeleteReportTemplateCommandInterface $command): bool
    {
        /** @var ReportTemplateInterface $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getId());

        if (!$reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report Template was not created";
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getUser()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        return $this->check();
    }
}
