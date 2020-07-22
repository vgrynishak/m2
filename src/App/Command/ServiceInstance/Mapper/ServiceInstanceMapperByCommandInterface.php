<?php

namespace App\App\Command\ServiceInstance\Mapper;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

interface ServiceInstanceMapperByCommandInterface
{
    /**
     * @param MessageInterface $command
     * @return ServiceInstanceInterface
     */
    public function map(MessageInterface $command): ServiceInstanceInterface;
}
