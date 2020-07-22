<?php


namespace App\App\Command\Section\Validator;

use App\App\Command\Section\EditSectionCommandInterface;
use App\App\Component\CQRS\Command\BaseCommandValidator;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class EditSectionValidator extends BaseCommandValidator implements EditSectionValidatorInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * EditSectionValidator constructor.
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
     * @param EditSectionCommandInterface $command
     * @return bool
     */
    public function validate(EditSectionCommandInterface $command): bool
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

        if (strlen($command->getTitle()) < 3) {
            $this->errors[] = "New section`s title can not be less than 3";
        }

        if (strlen($command->getTitle()) > 256) {
            $this->errors[] = "New section`s title can not be more than 256";
        }

        return $this->check();
    }
}
