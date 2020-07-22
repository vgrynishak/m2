<?php

namespace App\App\Command\Device\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceInterface;

interface DeviceMapperByCommandInterface
{
    /**
     * @param MessageInterface $command
     * @return DeviceInterface
     */
    public function map(MessageInterface $command): DeviceInterface;
}
