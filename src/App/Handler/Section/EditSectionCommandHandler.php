<?php

namespace App\App\Handler\Section;

use App\App\Command\Section\EditSectionCommandInterface;
use App\App\Command\Section\Validator\EditSectionValidatorInterface;
use App\App\UseCase\Section\EditSectionUseCaseInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Infrastructure\Exception\Section\FailEditSectionAction;
use Exception;

class EditSectionCommandHandler
{
    /** @var EditSectionValidatorInterface */
    private $editSectionValidator;
    /** @var EditSectionUseCaseInterface */
    private $editSectionUseCase;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;

    /**
     * EditSectionCommandHandler constructor.
     * @param EditSectionValidatorInterface $editSectionValidator
     * @param EditSectionUseCaseInterface $editSectionUseCase
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     */
    public function __construct(
        EditSectionValidatorInterface $editSectionValidator,
        EditSectionUseCaseInterface $editSectionUseCase,
        SectionCommandRepositoryInterface $sectionCommandRepository
    ) {
        $this->editSectionValidator = $editSectionValidator;
        $this->editSectionUseCase = $editSectionUseCase;
        $this->sectionCommandRepository = $sectionCommandRepository;
    }

    /**
     * @param EditSectionCommandInterface $command
     * @throws FailEditSectionAction
     */
    public function __invoke(EditSectionCommandInterface $command)
    {
        if (!$this->editSectionValidator->validate($command)) {
            throw new FailEditSectionAction($this->editSectionValidator->getFirstErrorMessage());
        }

        try {
            $section = $this->editSectionUseCase->edit($command);

            $this->sectionCommandRepository->update($section);
        } catch (Exception $exception) {
            throw new FailEditSectionAction($exception->getMessage());
        }
    }
}