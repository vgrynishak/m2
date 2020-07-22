<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDevice;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class CreateChildWithDeviceValidator extends BaseCommandValidator implements CreateChildWithDeviceValidatorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;

    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;

    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;

    /** @var StyleTemplateQueryRepositoryInterface */
    private $styleTemplateQueryRepository;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        StyleTemplateQueryRepositoryInterface $styleTemplateQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->styleTemplateQueryRepository = $styleTemplateQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param CreateChildWithDeviceCommandInterface $command
     * @return bool
     */
    public function validate(CreateChildWithDeviceCommandInterface $command): bool
    {
        /** @var ChildParagraphWithDevice $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());
        if ($paragraph instanceof BaseParagraphInterface) {
            $this->errors[] = 'Duplicate paragraph ID';
        }

        /** @var BaseParagraphInterface $paragraph */
        $parentParagraph = $this->paragraphQueryRepository->find($command->getParentId());
        if (!$parentParagraph instanceof BaseParagraphInterface) {
            $this->errors[] = 'Parent paragraph was not found';
        }

        if ($parentParagraph instanceof ChildParagraphWithDeviceInterface && $parentParagraph->getLevel() >= 3) {
            $this->errors[] = 'Maximum nesting level reached';
        }

        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find($command->getDeviceId());
        if (!$device instanceof DeviceInterface) {
            $this->errors[] = 'Invalid device';
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
