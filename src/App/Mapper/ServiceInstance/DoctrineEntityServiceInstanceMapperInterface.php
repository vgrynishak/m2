<?php

namespace App\App\Mapper\ServiceInstance;

use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface DoctrineEntityServiceInstanceMapperInterface
{
    /**
     * @param ServiceInstanceEntity $serviceInstanceEntity
     * @return ServiceInstanceInterface
     */
    public function map(ServiceInstanceEntity $serviceInstanceEntity): ServiceInstanceInterface;
}
