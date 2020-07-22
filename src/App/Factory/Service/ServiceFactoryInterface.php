<?php

namespace App\App\Factory\Service;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;

interface ServiceFactoryInterface
{
    /**
     * @param ServiceId $serviceId
     * @param DeviceId $deviceId
     * @param FacilityInterface $facility
     * @param string $name
     * @return ServiceInterface
     */
    public function make(
        ServiceId $serviceId,
        DeviceId $deviceId,
        FacilityInterface $facility,
        string $name
    ): ServiceInterface;
}
