<?php

namespace App\App\Factory\Section;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Section\Section;
use App\Core\Model\Section\SectionInterface;
use PhpCollection\Set;

class SectionFactory implements SectionFactoryInterface
{
    /**
     * @param MessageInterface $command
     * @return SectionInterface
     */
    public function makeByCommand(MessageInterface $command): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = new Section(
            $command->getId(),
            $command->getReportTemplateId(),
            $command->getTitle()
        );
        $section->setParagraphs(new Set);

        return $section;
    }
}
