<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\App\Repository\Section\SectionQueryRepository;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateRootWithDeviceValidator extends BaseCommandValidator implements CreateRootWithDeviceValidatorInterface
{
    /** @var string */
    public $message;

    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;

    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    /** @var SectionQueryRepository */
    private $sectionQueryRepository;

    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;

    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->styleTemplateQueryRepository = $styleTemplateQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateRootWithDeviceCommandInterface $command
     *
     * @return bool
     * @throws \Exception
     */
    public function validate(CreateRootWithDeviceCommandInterface $command): bool
    {
        /** @var RootParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());
        if ($paragraph instanceof BaseParagraphInterface) {
            $this->errors[] = 'Duplicate paragraph ID';
        }

        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        if (!$device instanceof DeviceInterface) {
            $this->errors[] = 'Invalid device';
        }

        /** @var SectionInterface $section */
        $section = $this->sectionQueryRepository->find($command->getSectionId());
        if (!$section instanceof SectionInterface) {
            $this->errors[] = 'Invalid section';
        }

        /** @var ParagraphFilterInterface $paragraphFilter */
        $paragraphFilter = $this->paragraphFilterQueryRepository->find($command->getParagraphFilterId());
        if (!$paragraphFilter instanceof ParagraphFilterInterface) {
            $this->errors[] = 'Invalid filter';
        }

        /** @var StyleTemplateInterface $styleTemplate */
        $styleTemplate = $this->styleTemplateQueryRepository->find($command->getStyleTemplateId());
        if (!$styleTemplate instanceof StyleTemplateInterface) {
            $this->errors[] = 'Invalid style template';
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getCreatedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not found";
        }

        /** @var BaseHeaderInterface $header */
        $header = $command->getHeader();
        if ($header instanceof NoHeaderInterface) {
            $this->errors[] = "Invalid Header";
        }

        return $this->check();
    }
}
