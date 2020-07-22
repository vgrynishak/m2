<?php

namespace App\App\Handler\Section;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\App\Command\Section\Validator\ChangeSectionPositionValidatorInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionCommandRepositoryInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Infrastructure\Exception\Section\FailChangeSectionPositionAction;
use Exception;

class ChangeSectionPositionHandler
{
    /** @var ChangeSectionPositionValidatorInterface */
    private $changeSectionPositionValidator;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var SectionCommandRepositoryInterface */
    private $sectionCommandRepository;

    /**
     * ChangeSectionPositionHandler constructor.
     * @param ChangeSectionPositionValidatorInterface $changeSectionPositionValidator
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param SectionCommandRepositoryInterface $sectionCommandRepository
     */
    public function __construct(
        ChangeSectionPositionValidatorInterface $changeSectionPositionValidator,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        SectionCommandRepositoryInterface $sectionCommandRepository
    ) {
        $this->changeSectionPositionValidator = $changeSectionPositionValidator;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->sectionCommandRepository = $sectionCommandRepository;
    }

    /**
     * @param ChangeSectionPositionCommandInterface $command
     * @throws FailChangeSectionPositionAction
     */
    public function __invoke(ChangeSectionPositionCommandInterface $command)
    {
        if (!$this->changeSectionPositionValidator->validate($command)) {
            throw new FailChangeSectionPositionAction($this->changeSectionPositionValidator->getFirstErrorMessage());
        }

        try {
            /** @var SectionInterface $section */
            $section = $this->sectionQueryRepository->find($command->getId());

            $this->sectionCommandRepository->changePosition(
                $section,
                $command->getNewPosition(),
                $command->getModifiedBy()->getId()
            );
        } catch (Exception $exception) {
            throw new FailChangeSectionPositionAction($exception->getMessage());
        }
    }
}
