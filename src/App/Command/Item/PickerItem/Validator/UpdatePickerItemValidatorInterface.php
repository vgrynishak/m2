<?php

namespace App\App\Command\Item\PickerItem\Validator;

use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use InvalidArgumentException;

interface UpdatePickerItemValidatorInterface
{
    /**
     * @param UpdatePickerItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(UpdatePickerItemCommandInterface $command): bool;
}
