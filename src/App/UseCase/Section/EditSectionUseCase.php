<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\EditSectionCommandInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use DateTime;
use Exception;

class EditSectionUseCase implements EditSectionUseCaseInterface
{
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;

    /**
     * EditSectionUseCase constructor.
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     */
    public function __construct(SectionQueryRepositoryInterface $sectionQueryRepository)
    {
        $this->sectionQueryRepository = $sectionQueryRepository;
    }

    /**
     * @param EditSectionCommandInterface $command
     * @return SectionInterface
     * @throws Exception
     */
    public function edit(EditSectionCommandInterface $command): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionQueryRepository->find($command->getId());

        $section->setTitle($command->getTitle());
        $section->setModifiedBy($command->getModifiedBy());
        $section->setModifiedAt(new DateTime());
        
        return $section;
    }
}
