<?php

namespace App\App\Doctrine\Mapper\Service;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\Core\Model\Service\ServiceInterface;

interface ServiceModelInterface
{
    /**
     * @param ServiceInterface $service
     * @return ServiceEntity
     */
    public function map(ServiceInterface $service): ServiceEntity;

    /**
     * @param ServiceInterface $service
     * @return ServiceEntity
     */
    public function mapNew(ServiceInterface $service): ServiceEntity;
}
