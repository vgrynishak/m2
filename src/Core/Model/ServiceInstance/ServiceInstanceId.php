<?php

namespace App\Core\Model\ServiceInstance;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\ModelId;

class ServiceInstanceId extends ModelId
{
    /**
     * ServiceInstanceId constructor.
     * @param string $value
     * @throws InvalidServiceInstanceIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidServiceInstanceIdException('Invalid ServiceInstanceId given');
        }
    }
}
