<?php


namespace App\App\Command\Section\Validator;

use App\App\Command\Section\EditSectionCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface EditSectionValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param EditSectionCommandInterface $command
     * @return bool
     */
    public function validate(EditSectionCommandInterface $command): bool;
}
