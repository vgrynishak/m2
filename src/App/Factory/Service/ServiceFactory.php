<?php

namespace App\App\Factory\Service;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\Service;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use DateTime;
use Exception;

class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * @param ServiceId $serviceId
     * @param DeviceId $deviceId
     * @param FacilityInterface $facility
     * @param string $name
     * @return ServiceInterface
     * @throws Exception
     */
    public function make(
        ServiceId $serviceId,
        DeviceId $deviceId,
        FacilityInterface $facility,
        string $name
    ): ServiceInterface {
        $service = new Service(
            $serviceId,
            $deviceId,
            $facility,
            $name
        );

        $this->fillBase($service);
        return $service;
    }

    /**
     * @param ServiceInterface $service
     * @throws Exception
     */
    private function fillBase(ServiceInterface $service)
    {
        $service->setCreatedAt(new DateTime());
        $service->setUpdatedAt($service->getCreatedAt());
    }
}
