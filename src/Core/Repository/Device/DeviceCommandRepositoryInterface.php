<?php

namespace App\Core\Repository\Device;

use App\Core\Model\Device\DeviceInterface;

interface DeviceCommandRepositoryInterface
{
    public function create(DeviceInterface $device);
}
