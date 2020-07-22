<?php

namespace App\App\Component\Validator;

interface ErrorManagerInterface
{
    /**
     * @return array
     */
    public function getErrors(): array;

    public function getFirstErrorMessage();
}
