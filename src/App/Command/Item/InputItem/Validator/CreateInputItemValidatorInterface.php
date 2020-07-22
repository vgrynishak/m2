<?php

namespace App\App\Command\Item\InputItem\Validator;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use \InvalidArgumentException;

interface CreateInputItemValidatorInterface
{
    /**
     * @param CreateInputItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(CreateInputItemCommandInterface $command): bool;
}
