<?php

namespace App\App\Command\Section\Mapper;

use App\App\Component\Message\MessageInterface;
use App\App\Factory\Section\SectionFactoryInterface;
use App\Core\Model\Section\SectionInterface;

class SectionMapperByCommand implements SectionMapperByCommandInterface
{
    /** @var SectionFactoryInterface */
    private $sectionFactory;

    /**
     * SectionMapperByCommand constructor.
     * @param SectionFactoryInterface $sectionFactory
     */
    public function __construct(SectionFactoryInterface $sectionFactory)
    {
        $this->sectionFactory = $sectionFactory;
    }

    /**
     * @param MessageInterface $command
     * @return SectionInterface
     */
    public function map(MessageInterface $command): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->makeByCommand($command);

        $section->setCreatedBy($command->getCreatedBy());
        $section->setModifiedBy($command->getCreatedBy());
        $section->setCreatedAt($command->getCreatedAt());
        $section->setModifiedAt($command->getCreatedAt());

        return $section;
    }
}
