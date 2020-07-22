<?php

namespace App\Core\Repository\ServiceInstance;

use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface ServiceInstanceQueryRepositoryInterface
{
    /**
     * @param ServiceInstanceId $id
     * @return ServiceInstanceInterface|null
     */
    public function find(ServiceInstanceId $id): ?ServiceInstanceInterface;
}
