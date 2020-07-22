<?php

namespace App\App\Mapper\Device;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\Core\Model\Device\DeviceInterface;

interface DoctrineEntityDeviceMapperInterface
{
    /**
     * @param DeviceEntity $deviceEntity
     * @return DeviceInterface
     */
    public function map(DeviceEntity $deviceEntity): DeviceInterface;
}
