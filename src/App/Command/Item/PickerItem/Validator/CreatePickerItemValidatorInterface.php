<?php

namespace App\App\Command\Item\PickerItem\Validator;

use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use InvalidArgumentException;

interface CreatePickerItemValidatorInterface
{
    /**
     * @param CreatePickerItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(CreatePickerItemCommandInterface $command): bool;
}
