<?php

namespace App\App\Component\CQRS\Command;

use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

abstract class BaseCommandValidator implements ValidatorErrorManagerInterface
{
    /** @var array */
    protected $errors = [];

    /**
     * @return bool
     */
    protected function check(): bool
    {
        if (count($this->errors) !== 0) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getFirstErrorMessage()
    {
        $firstKey = array_key_first($this->errors);

        return $this->errors[$firstKey];
    }
}
