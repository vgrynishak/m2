<?php

namespace App\Core\Repository\DeviceInstance;

use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface DeviceInstanceQueryRepositoryInterface
{
    /**
     * @param DeviceInstanceId $id
     * @return DeviceInstanceInterface|null
     */
    public function find(DeviceInstanceId $id): ?DeviceInstanceInterface;
}
