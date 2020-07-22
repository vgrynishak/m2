<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use PhpCollection\CollectionInterface;

class DeleteSectionValidator extends BaseCommandValidator implements DeleteSectionValidatorInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * DeleteSectionValidator constructor.
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
     * @param DeleteSectionCommandInterface $command
     * @return bool
     */
    public function validate(DeleteSectionCommandInterface $command): bool
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

        if ($section instanceof SectionInterface and $section->getParagraphs() instanceof CollectionInterface) {
            $this->errors[] = "Section which contains paragraphs can not be deleted";
        }

        return $this->check();
    }
}
