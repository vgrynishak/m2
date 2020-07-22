<?php

namespace App\App\Command\Paragraph\Validator;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface DeleteParagraphValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param DeleteParagraphCommandInterface $command
     * @return bool
     */
    public function validate(DeleteParagraphCommandInterface $command): bool;
}
