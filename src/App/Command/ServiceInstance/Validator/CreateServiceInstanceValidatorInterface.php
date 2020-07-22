<?php

namespace App\App\Command\ServiceInstance\Validator;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateServiceInstanceValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param CreateServiceInstanceCommandInterface $command
     * @return bool
     */
    public function validate(CreateServiceInstanceCommandInterface $command): bool;
}
