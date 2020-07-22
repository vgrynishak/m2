<?php

namespace App\App\Command\Item\ListItem\Validator;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use InvalidArgumentException;

interface CreateListItemValidatorInterface
{
    /**
     * @param CreateListItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(CreateListItemCommandInterface $command): bool;
}
