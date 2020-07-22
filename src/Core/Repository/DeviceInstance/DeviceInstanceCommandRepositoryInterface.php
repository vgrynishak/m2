<?php

namespace App\Core\Repository\DeviceInstance;

use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface DeviceInstanceCommandRepositoryInterface
{
    /**
     * @param DeviceInstanceInterface $deviceInstance
     */
    public function create(DeviceInstanceInterface $deviceInstance): void;
}
