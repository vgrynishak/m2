<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateRootWithDeviceValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(CreateRootWithDeviceCommandInterface $command): bool;
}
