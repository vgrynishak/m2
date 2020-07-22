<?php

namespace App\Core\Model\DeviceDynamicField;

use App\Core\Model\Exception\InvalidDeviceDynamicFieldIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class DeviceDynamicFieldId extends ModelStringId
{
    /**
     * DeviceDynamicFieldId constructor.
     * @param string $value
     * @throws InvalidDeviceDynamicFieldIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidDeviceDynamicFieldIdException("Invalid DeviceDynamicFieldId given");
        }
    }
}
