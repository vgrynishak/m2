<?php

namespace App\Core\Repository\ServiceInstance;

use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface ServiceInstanceCommandRepositoryInterface
{
    /**
     * @param ServiceInstanceInterface $serviceInstance
     */
    public function create(ServiceInstanceInterface $serviceInstance): void;
}
