<?php

namespace App\App\Command\Item\InputItem\Validator;

use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use InvalidArgumentException;

interface UpdateInputItemValidatorInterface
{
    /**
     * @param UpdateInputItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(UpdateInputItemCommandInterface $command): bool;
}
