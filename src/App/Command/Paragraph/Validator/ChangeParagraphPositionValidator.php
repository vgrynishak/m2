<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class ChangeParagraphPositionValidator extends BaseCommandValidator implements ChangeParagraphPositionValidatorInterface
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
     * @param ChangeParagraphPositionCommandInterface $command
     * @return bool
     */
    public function validate(ChangeParagraphPositionCommandInterface $command): bool
    {
        /** @var BaseParagraphInterface|null $paragraph */
        $paragraph = $this->paragraphQueryRepository->find($command->getId());

        if (!$paragraph instanceof BaseParagraphInterface) {
            $this->errors[] = 'Paragraph is not exist';
        }

        /** @var UserInterface|null $user */
        $user = $this->userQueryRepository->find($command->getModifiedBy()->getId());
        if (!$user instanceof UserInterface) {
            $this->errors[] = "Modified User was not found";
        }

        if ($command->getNewPosition() < 1) {
            $this->errors[] = "New position can not be lass than 1";
        }

        return $this->check();
    }
}
