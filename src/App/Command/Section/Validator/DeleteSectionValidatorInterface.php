<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface DeleteSectionValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param DeleteSectionCommandInterface $command
     * @return bool
     */
    public function validate(DeleteSectionCommandInterface $command): bool;
}
