<?php

namespace App\App\Command\DeviceInstance\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface DeviceInstanceMapperByCommandInterface
{
    /**
     * @param MessageInterface $command
     * @return DeviceInstanceInterface
     */
    public function map(MessageInterface $command): DeviceInstanceInterface;
}
