<?php

namespace App\Core\Model\Service;

use App\Core\Model\ModelId;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidModelIdException;

class ServiceId extends ModelId
{
    /**
     * ServiceId constructor.
     * @param string $value
     *
     * @throws InvalidServiceIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidServiceIdException('Invalid ServiceId given');
        }
    }
}
