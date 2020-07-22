<?php

namespace App\App\Mapper;

use App\App\Component\Message\MessageInterface;

interface MapperInterface
{
    public function map(MessageInterface $command);
}
