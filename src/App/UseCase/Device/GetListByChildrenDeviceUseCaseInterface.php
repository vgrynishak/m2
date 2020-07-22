<?php

namespace App\App\UseCase\Device;

use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use PhpCollection\CollectionInterface;

interface GetListByChildrenDeviceUseCaseInterface
{
    /**
     * @param FindByChildrenDeviceQueryInterface $query
     * @return CollectionInterface
     * @throws ChildrenDeviceInvalidLevelException
     * @throws \Exception
     */
    public function getList(FindByChildrenDeviceQueryInterface $query) : CollectionInterface;
}
