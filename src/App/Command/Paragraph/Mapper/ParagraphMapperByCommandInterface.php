<?php

namespace App\App\Command\Paragraph\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;

interface ParagraphMapperByCommandInterface
{
    public function map(MessageInterface $command): BaseParagraphInterface;
}
