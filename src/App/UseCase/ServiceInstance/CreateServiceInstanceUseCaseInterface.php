<?php

namespace App\App\UseCase\ServiceInstance;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface CreateServiceInstanceUseCaseInterface
{
    /**
     * @param CreateServiceInstanceCommandInterface $command
     * @return ServiceInstanceInterface
     */
    public function create(CreateServiceInstanceCommandInterface $command): ServiceInstanceInterface;
}
