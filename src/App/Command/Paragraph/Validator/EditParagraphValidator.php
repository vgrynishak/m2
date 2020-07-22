<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class EditParagraphValidator extends BaseCommandValidator implements EditParagraphValidatorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * ChangeParagraphPositionValidator constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param EditParagraphCommandInterface $command
     * @return bool
     */
    public function validate(EditParagraphCommandInterface $command): bool
    {
        /** @var BaseHeaderInterface $header */
        $header = $command->getHeader();

        if ($header instanceof CustomHeaderInterface) {
            if (strlen($header->getValue()) > 100) {
                $this->errors[] = "Title length must be less then 100";
            }
            if (strlen($header->getValue()) < 3) {
                $this->errors[] = "Title length must be greater then 3";
            }
        }

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "User was not created";
        }

        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());
        if (!$paragraph instanceof BaseParagraphInterface) {
            $this->errors[] = "Paragraph with this Id not exists";
        }

        return $this->check();
    }
}
