<?php

namespace App\App\Doctrine\Mapper\Device;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\Core\Model\Device\DeviceInterface;

interface DeviceModelInterface
{
    /**
     * @param DeviceInterface $device
     * @return DeviceEntity
     */
    public function map(DeviceInterface $device): DeviceEntity;

    /**
     * @param DeviceInterface $device
     * @return DeviceEntity
     */
    public function mapNew(DeviceInterface $device): DeviceEntity;
}
