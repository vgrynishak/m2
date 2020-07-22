<?php

namespace App\App\Query\Device\Validator;

use App\App\Query\Device\FindByRootDeviceQueryInterface;

class FindByRootDeviceValidator extends BaseGroupValidator implements FindByRootDeviceValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate(FindByRootDeviceQueryInterface $query): bool
    {
        $this->baseValidate($query->getId());

        return true;
    }
}
