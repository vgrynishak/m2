<?php

namespace App\App\UseCase\Device;

use App\App\Query\Device\FindByRootDeviceQueryInterface;
use App\App\Service\Exception\RootDeviceInvalidLevelException;
use PhpCollection\CollectionInterface;

interface GetListByRootDeviceUseCaseInterface
{
    /**
     * @param FindByRootDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws RootDeviceInvalidLevelException
     * @throws \Exception
     */
    public function getList(FindByRootDeviceQueryInterface $query) : CollectionInterface;
}
