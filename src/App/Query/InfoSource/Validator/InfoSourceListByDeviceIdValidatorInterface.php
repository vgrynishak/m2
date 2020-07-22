<?php

namespace App\App\Query\InfoSource\Validator;

use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;

interface InfoSourceListByDeviceIdValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param InfoSourceListByDictionaryIdQueryInterface $command
     * @return bool
     */
    public function validate(InfoSourceListByDictionaryIdQueryInterface $command): bool;
}
