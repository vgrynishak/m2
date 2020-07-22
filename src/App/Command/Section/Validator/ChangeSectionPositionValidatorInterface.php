<?php

namespace App\App\Command\Section\Validator;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface ChangeSectionPositionValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param ChangeSectionPositionCommandInterface $command
     * @return bool
     */
    public function validate(ChangeSectionPositionCommandInterface $command): bool;
}
