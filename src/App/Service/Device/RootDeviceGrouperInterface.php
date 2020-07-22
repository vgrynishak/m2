<?php

namespace App\App\Service\Device;

use App\Core\Model\Device\DeviceInterface;
use PhpCollection\CollectionInterface;

interface RootDeviceGrouperInterface
{
    public const MAX_DEPTH = 2;

    public function group(DeviceInterface $targetDevice, CollectionInterface $arrayDevice) : CollectionInterface;
}
