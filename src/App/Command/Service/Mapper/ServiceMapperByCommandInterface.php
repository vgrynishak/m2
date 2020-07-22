<?php

namespace App\App\Command\Service\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Service\ServiceInterface;

interface ServiceMapperByCommandInterface
{
    public function map(MessageInterface $command): ServiceInterface;
}
