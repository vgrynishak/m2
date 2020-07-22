<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class ChangeSectionPositionValidator extends BaseCommandValidator implements ChangeSectionPositionValidatorInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * ChangeSectionPositionValidator constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        SectionQueryRepositoryInterface $sectionQueryRepository,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param ChangeSectionPositionCommandInterface $command
     * @return bool
     */
    public function validate(ChangeSectionPositionCommandInterface $command): bool
    {
        /** @var SectionInterface|null $section */
        $section = $this->sectionQueryRepository->find($command->getId());

        if (!$section instanceof SectionInterface) {
            $this->errors[] = 'Section is not exist';
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
