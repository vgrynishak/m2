<?php

namespace App\App\Mapper\Service;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\Core\Model\Service\ServiceInterface;

interface DoctrineEntityServiceMapperInterface
{
    /**
     * @param ServiceEntity $deviceInstanceEntity
     * @return ServiceInterface
     */
    public function map(ServiceEntity $deviceInstanceEntity): ServiceInterface;
}
