<?php

namespace App\App\Doctrine\Mapper\DeviceInstance;

use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

interface DeviceInstanceModelInterface
{
    /**
     * @param DeviceInstanceInterface $deviceInstance
     * @return DeviceInstanceEntity
     */
    public function mapNew(DeviceInstanceInterface $deviceInstance): DeviceInstanceEntity;
}
