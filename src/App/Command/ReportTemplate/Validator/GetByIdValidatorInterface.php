<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface GetByIdValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(GetByIdCommandInterface $command): bool;
}
