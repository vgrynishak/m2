<?php

namespace App\App\Doctrine\Mapper\ServiceInstance;

use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface ServiceInstanceModelInterface
{
    /**
     * @param ServiceInstanceInterface $serviceInstance
     * @return ServiceInstanceEntity
     */
    public function mapNew(ServiceInstanceInterface $serviceInstance): ServiceInstanceEntity;
}
