<?php

namespace App\App\Mapper\DeviceInstance;

use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface DoctrineEntityDeviceInstanceMapperInterface
{
    /**
     * @param DeviceInstanceEntity $deviceInstanceEntity
     * @return DeviceInstanceInterface
     */
    public function map(DeviceInstanceEntity $deviceInstanceEntity): DeviceInstanceInterface;
}
