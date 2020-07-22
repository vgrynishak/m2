<?php

namespace App\App\Factory\ServiceInstance;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstance;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use DateTime;
use Exception;

class ServiceInstanceFactory implements ServiceInstanceFactoryInterface
{
    /**
     * @param ServiceInstanceId $id
     * @param ServiceInterface $service
     * @param FacilityId $facilityId
     * @return ServiceInstanceInterface
     * @throws Exception
     */
    public function make(
        ServiceInstanceId $id,
        ServiceInterface $service,
        FacilityId $facilityId
    ): ServiceInstanceInterface {
        $serviceInstance = new ServiceInstance($id, $service, $facilityId);
        $this->fillBase($serviceInstance);

        return $serviceInstance;
    }

    /**
     * @param ServiceInstanceInterface $serviceInstance
     * @throws Exception
     */
    private function fillBase(ServiceInstanceInterface $serviceInstance): void
    {
        $serviceInstance->setCreatedAt(new DateTime());
        $serviceInstance->setModifiedAt($serviceInstance->getCreatedAt());
    }
}
