<?php

namespace App\Core\Model\Device;

use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class DeviceId extends ModelId
{
    /**
     * DeviceId constructor.
     * @param string $value
     * @throws InvalidDeviceIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidDeviceIdException('Invalid DeviceId given');
        }
    }
}
