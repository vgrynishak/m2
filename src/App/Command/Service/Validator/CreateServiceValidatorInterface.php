<?php

namespace App\App\Command\Service\Validator;

use App\App\Command\Service\CreateServiceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateServiceValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(CreateServiceCommandInterface $command): bool;
}
