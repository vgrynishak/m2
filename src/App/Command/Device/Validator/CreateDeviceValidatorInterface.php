<?php

namespace App\App\Command\Device\Validator;

use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateDeviceValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param CreateDeviceCommandInterface $command
     * @return bool
     */
    public function validate(CreateDeviceCommandInterface $command): bool;
}
