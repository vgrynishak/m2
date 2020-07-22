<?php

namespace App\App\UseCase\Section;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Command\Section\Mapper\SectionMapperByCommandInterface;
use App\Core\Model\Section\SectionInterface;
use App\Core\Service\Section\PositionIteratorInterface;

class CreateSectionUseCase implements CreateSectionUseCaseInterface
{
    /** @var PositionIteratorInterface */
    public $positionIterator;
    /** @var SectionMapperByCommandInterface */
    public $mapperByCommand;

    /**
     * CreateSectionUseCase constructor.
     * @param SectionMapperByCommandInterface $mapperByCommand
     * @param PositionIteratorInterface $positionIterator
     */
    public function __construct(
        SectionMapperByCommandInterface $mapperByCommand,
        PositionIteratorInterface $positionIterator
    ) {
        $this->positionIterator = $positionIterator;
        $this->mapperByCommand = $mapperByCommand;
    }

    /**
     * @param CreateSectionCommand $command
     * @return SectionInterface
     */
    public function create(CreateSectionCommand $command): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->mapperByCommand->map($command);
        $section->setPosition($this->positionIterator->next($command->getReportTemplateId()));
        $section->setPrintable(true);

        return $section;
    }
}
