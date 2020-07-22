<?php

namespace App\Core\Repository\Service;

use App\Core\Model\Service\ServiceInterface;

interface ServiceCommandRepositoryInterface
{
    /**
     * @param ServiceInterface $service
     */
    public function create(ServiceInterface $service);
}
