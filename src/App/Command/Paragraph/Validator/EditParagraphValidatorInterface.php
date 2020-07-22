<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface EditParagraphValidatorInterface extends ValidatorErrorManagerInterface
{
    public function validate(EditParagraphCommandInterface $command): bool;
}
