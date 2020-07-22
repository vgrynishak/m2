<?php


namespace App\App\Command\Item\PictureItem\Validator;

use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use InvalidArgumentException;

interface CreatePictureItemValidatorInterface
{
    /**
     * @param CreatePictureItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(CreatePictureItemCommandInterface $command): bool;
}