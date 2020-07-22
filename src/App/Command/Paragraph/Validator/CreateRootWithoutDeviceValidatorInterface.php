<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateRootWithoutDeviceValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(CreateRootWithoutDeviceCommandInterface $command): bool;
}
