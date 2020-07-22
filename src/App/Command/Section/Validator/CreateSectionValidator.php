<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\CreateSectionCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\Section\Section;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateSectionValidator extends BaseCommandValidator implements CreateSectionValidatorInterface
{
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateSectionValidator constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateSectionCommandInterface $command
     * @return bool
     */
    public function validate(CreateSectionCommandInterface $command): bool
    {
        /** @var ReportTemplate $reportTemplate */
        $reportTemplate = $this->reportTemplateQueryRepository->find($command->getReportTemplateId());
        if (!$reportTemplate instanceof ReportTemplateInterface) {
            $this->errors[] = "Report template was not found";
        }

        /** @var Section $section */
        $section = $this->sectionQueryRepository->find($command->getId());
        if ($section instanceof SectionInterface) {
            $this->errors[] = "Section has already created";
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        if (strlen($command->getTitle()) < 3) {
            $this->errors[] = "Section`s title can not be less than 3";
        }

        if (strlen($command->getTitle()) > 500) {
            $this->errors[] = "Section`s title can not be more than 500";
        }

        return $this->check();
    }
}
