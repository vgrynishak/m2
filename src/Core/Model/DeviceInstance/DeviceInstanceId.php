<?php

namespace App\Core\Model\DeviceInstance;

use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class DeviceInstanceId extends ModelId
{
    /**
     * DeviceInstanceId constructor.
     * @param string $value
     * @throws InvalidDeviceInstanceIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidDeviceInstanceIdException('Invalid DeviceInstanceId given');
        }
    }
}
