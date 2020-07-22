<?php

namespace App\App\Query\Device\Validator;

use App\App\Query\Device\FindByRootDeviceQueryInterface;

interface FindByRootDeviceValidatorInterface
{
    /**
     * @param FindByRootDeviceQueryInterface $query
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function validate(FindByRootDeviceQueryInterface $query): bool;
}
