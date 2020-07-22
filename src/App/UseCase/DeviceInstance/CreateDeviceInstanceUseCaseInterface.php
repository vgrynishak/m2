<?php

namespace App\App\UseCase\DeviceInstance;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface CreateDeviceInstanceUseCaseInterface
{
    /**
     * @param CreateDeviceInstanceCommandInterface $command
     * @return DeviceInstanceInterface
     */
    public function create(CreateDeviceInstanceCommandInterface $command): DeviceInstanceInterface;
}
