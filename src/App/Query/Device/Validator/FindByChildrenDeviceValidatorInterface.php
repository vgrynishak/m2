<?php

namespace App\App\Query\Device\Validator;

use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

interface FindByChildrenDeviceValidatorInterface
{
    /**
     * @param FindByChildrenDeviceQueryInterface $query
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(FindByChildrenDeviceQueryInterface $query): bool;
}
