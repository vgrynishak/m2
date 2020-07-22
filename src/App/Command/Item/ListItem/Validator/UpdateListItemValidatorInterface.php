<?php

namespace App\App\Command\Item\ListItem\Validator;

use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use InvalidArgumentException;

interface UpdateListItemValidatorInterface
{
    /**
     * @param UpdateListItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(UpdateListItemCommandInterface $command): bool;
}
