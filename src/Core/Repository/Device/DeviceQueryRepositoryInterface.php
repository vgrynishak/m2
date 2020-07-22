<?php

namespace App\Core\Repository\Device;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use PhpCollection\CollectionInterface;

interface DeviceQueryRepositoryInterface
{
    /**
     * @param DeviceId $deviceId
     * @return DeviceInterface|null
     */
    public function find(DeviceId $deviceId): ?DeviceInterface;

    /**
     * @return CollectionInterface|null
     */
    public function getTree() : ?CollectionInterface;
}
