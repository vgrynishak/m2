<?php

namespace App\App\Command\Item\DeviceInformationItem\Validator;

use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use InvalidArgumentException;

interface UpdateDeviceInformationItemValidatorInterface
{
    /**
     * @param UpdateDeviceInformationItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(UpdateDeviceInformationItemCommandInterface $command): bool;
}
