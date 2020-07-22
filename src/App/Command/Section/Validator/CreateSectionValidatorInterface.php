<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\CreateSectionCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateSectionValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param CreateSectionCommandInterface $command
     * @return bool
     */
    public function validate(CreateSectionCommandInterface $command): bool;
}
