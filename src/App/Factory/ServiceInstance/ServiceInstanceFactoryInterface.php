<?php

namespace App\App\Factory\ServiceInstance;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface ServiceInstanceFactoryInterface
{
    /**
     * @param ServiceInstanceId $id
     * @param ServiceInterface $service
     * @param FacilityId $facilityId
     * @return ServiceInstanceInterface
     */
    public function make(
        ServiceInstanceId $id,
        ServiceInterface $service,
        FacilityId $facilityId
    ): ServiceInstanceInterface;
}
