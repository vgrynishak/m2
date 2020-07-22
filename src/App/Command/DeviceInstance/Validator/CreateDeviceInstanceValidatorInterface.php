<?php

namespace App\App\Command\DeviceInstance\Validator;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateDeviceInstanceValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param CreateDeviceInstanceCommandInterface $command
     * @return bool
     */
    public function validate(CreateDeviceInstanceCommandInterface $command): bool;
}
