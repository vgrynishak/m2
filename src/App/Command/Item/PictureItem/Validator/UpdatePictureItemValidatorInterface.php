<?php


namespace App\App\Command\Item\PictureItem\Validator;

use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use InvalidArgumentException;

interface UpdatePictureItemValidatorInterface
{
    /**
     * @param UpdatePictureItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(UpdatePictureItemCommandInterface $command): bool;
}