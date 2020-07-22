<?php

namespace App\App\UseCase\Device;

use App\App\Command\Device\CreateDeviceCommandInterface;
use App\Core\Model\Device\DeviceInterface;

interface CreateDeviceUseCaseInterface
{
    /**
     * @param CreateDeviceCommandInterface $command
     * @return DeviceInterface
     */
    public function create(CreateDeviceCommandInterface $command): DeviceInterface;
}
