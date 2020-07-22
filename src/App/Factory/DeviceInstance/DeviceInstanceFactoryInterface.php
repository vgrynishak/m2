<?php

namespace App\App\Factory\DeviceInstance;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Facility\FacilityId;

interface DeviceInstanceFactoryInterface
{
    /**
     * @param DeviceInstanceId $id
     * @param DeviceInterface $device
     * @param FacilityId $facilityId
     * @return DeviceInstanceInterface
     */
    public function make(
        DeviceInstanceId $id,
        DeviceInterface $device,
        FacilityId $facilityId
    ): DeviceInstanceInterface;
}
