<?php

namespace App\App\Service\Device;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Device\GroupId;
use PhpCollection\CollectionInterface;

interface ChildrenDeviceGrouperInterface
{
    public const MAX_DEPTH = 2;

    public function group(DeviceInterface $targetDevice, CollectionInterface $arrayDevice, GroupId $groupId)
    : CollectionInterface;
}
