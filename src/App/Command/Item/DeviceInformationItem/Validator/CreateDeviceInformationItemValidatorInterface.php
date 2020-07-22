<?php

namespace App\App\Command\Item\DeviceInformationItem\Validator;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use InvalidArgumentException;

interface CreateDeviceInformationItemValidatorInterface
{
    /**
     * @param CreateDeviceInformationItemCommandInterface $command
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(CreateDeviceInformationItemCommandInterface $command): bool;
}
