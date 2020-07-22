<?php

namespace App\App\Query\Device;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\GroupId;

interface FindByChildrenDeviceQueryInterface
{
    public function getId(): DeviceId;

    public function getGroupId(): GroupId;
}
