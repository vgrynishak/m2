<?php

namespace App\App\Command\Section\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Section\SectionInterface;

interface SectionMapperByCommandInterface
{
    /**
     * @param MessageInterface $command
     * @return SectionInterface
     */
    public function map(MessageInterface $command): SectionInterface;
}
