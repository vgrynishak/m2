<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateChildWithDeviceValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(CreateChildWithDeviceCommandInterface $command): bool;
}
