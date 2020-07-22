<?php

namespace App\App\Factory\Section;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Section\SectionInterface;

interface SectionFactoryInterface
{
    /**
     * @param MessageInterface $command
     * @return SectionInterface
     */
    public function makeByCommand(MessageInterface $command): SectionInterface;
}
