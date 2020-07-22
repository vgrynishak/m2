<?php

namespace App\App\Handler\Section;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Command\Section\Validator\CreateSectionValidatorInterface;
use App\App\UseCase\Section\CreateSectionUseCaseInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Infrastructure\Exception\Section\FailCreateSectionAction;
use Exception;

class CreateSectionCommandHandler
{
    /** @var SectionCommandRepositoryInterface */
    private $sectionRepository;
    /** @var CreateSectionValidatorInterface */
    private $createSectionValidator;
    /** @var CreateSectionUseCaseInterface */
    private $createSectionUseCase;

    /**
     * CreateSectionCommandHandler constructor.
     * @param SectionCommandRepositoryInterface $sectionRepository
     * @param CreateSectionValidatorInterface $createSectionValidator
     * @param CreateSectionUseCaseInterface $createSectionUseCase
     */
    public function __construct(
        SectionCommandRepositoryInterface $sectionRepository,
        CreateSectionValidatorInterface $createSectionValidator,
        CreateSectionUseCaseInterface $createSectionUseCase
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->createSectionValidator = $createSectionValidator;
        $this->createSectionUseCase = $createSectionUseCase;
    }

    /**
     * @param CreateSectionCommand $command
     * @throws FailCreateSectionAction
     */
    public function __invoke(CreateSectionCommand $command): void
    {
        if (!$this->createSectionValidator->validate($command)) {
            throw new FailCreateSectionAction($this->createSectionValidator->getFirstErrorMessage());
        }

        try {
            /** @var SectionInterface $section */
            $section = $this->createSectionUseCase->create($command);
            $this->sectionRepository->create($section);
        } catch (Exception $exception) {
            throw new FailCreateSectionAction($exception->getMessage());
        }
    }
}
