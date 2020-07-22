<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class DeleteParagraphValidator extends BaseCommandValidator implements DeleteParagraphValidatorInterface
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * DeleteParagraphValidator constructor.
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
     * @param DeleteParagraphCommandInterface $command
     * @return bool
     */
    public function validate(DeleteParagraphCommandInterface $command): bool
    {
        /** @var BaseParagraphInterface $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());

        if (!$paragraph instanceof BaseParagraphInterface) {
            $this->errors[] = 'Paragraph is not exist';
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "Modified User was not found";
        }

        if ($paragraph instanceof BaseParagraphInterface and $paragraph instanceof WithDeviceParagraphInterface) {
            if ($paragraph->getChildren()) {
                $this->errors[] = "Paragraph which contains children can not be deleted";
            }
        }

        return $this->check();
    }
}
