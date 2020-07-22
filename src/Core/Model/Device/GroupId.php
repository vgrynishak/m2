<?php

namespace App\Core\Model\Device;

use App\Core\Model\Exception\InvalidGroupIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class GroupId extends ModelStringId
{
    /**
     * GroupId constructor.
     * @param string $value
     * @throws InvalidGroupIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidGroupIdException('Invalid GroupId given');
        }
    }
}