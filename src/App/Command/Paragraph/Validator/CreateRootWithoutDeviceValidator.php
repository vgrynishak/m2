<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateRootWithoutDeviceValidator extends BaseCommandValidator implements CreateRootWithoutDeviceValidatorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;

    /**
     * CreateRootWithoutDeviceValidator constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository
     */
    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository,
        StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
        $this->styleTemplateQueryRepository = $styleTemplateQueryRepository;
    }

    /**
     * @param CreateRootWithoutDeviceCommandInterface $command
     * @return bool
     */
    public function validate(CreateRootWithoutDeviceCommandInterface $command): bool
    {
        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());
        if ($paragraph instanceof RootParagraphWithoutDeviceInterface) {
            $this->errors[] = "Paragraph with this Id already exists";
        }

        /** @var SectionInterface $section */
        $section = $this->sectionQueryRepository->find($command->getSectionId());
        if (!$section instanceof SectionInterface) {
            $this->errors[] = "Section with this Id is not exists";
        }

        /** @var StyleTemplateInterface $styleTemplate */
        $styleTemplate = $this->styleTemplateQueryRepository->find($command->getStyleTemplateId());
        if (!$styleTemplate instanceof StyleTemplateInterface) {
            $this->errors[] = 'Invalid style template';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not created";
        }

        /** @var BaseHeaderInterface $header */
        $header = $command->getHeader();
        if ($header instanceof DeviceCardHeaderInterface) {
            $this->errors[] = "Invalid Header";
        }

        return $this->check();
    }
}

