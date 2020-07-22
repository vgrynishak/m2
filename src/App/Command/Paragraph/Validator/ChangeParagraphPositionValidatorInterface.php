<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface ChangeParagraphPositionValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param ChangeParagraphPositionCommandInterface $command
     * @return bool
     */
    public function validate(ChangeParagraphPositionCommandInterface $command): bool;
}
