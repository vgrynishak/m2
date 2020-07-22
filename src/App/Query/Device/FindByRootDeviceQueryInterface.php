<?php

namespace App\App\Query\Device;

use App\Core\Model\Device\DeviceId;

interface FindByRootDeviceQueryInterface
{
    public function getId(): DeviceId;
}
