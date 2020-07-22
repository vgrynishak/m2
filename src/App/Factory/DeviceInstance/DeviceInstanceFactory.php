<?php

namespace App\App\Factory\DeviceInstance;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstance;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Facility\FacilityId;
use DateTime;
use Exception;

class DeviceInstanceFactory implements DeviceInstanceFactoryInterface
{
    /**
     * @param DeviceInstanceId $id
     * @param DeviceInterface $device
     * @param FacilityId $facilityId
     * @return DeviceInstanceInterface
     * @throws Exception
     */
    public function make(DeviceInstanceId $id, DeviceInterface $device, FacilityId $facilityId): DeviceInstanceInterface
    {
        $deviceInstance = new DeviceInstance($id, $device, $facilityId);
        $this->fillBase($deviceInstance);

        return $deviceInstance;
    }

    /**
     * @param DeviceInstanceInterface $deviceInstance
     * @throws Exception
     */
    private function fillBase(DeviceInstanceInterface $deviceInstance): void
    {
        $deviceInstance->setCreatedAt(new DateTime());
        $deviceInstance->setModifiedAt($deviceInstance->getCreatedAt());
    }
}
