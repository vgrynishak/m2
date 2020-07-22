<?php

namespace App\Core\Model\DeviceDynamicField;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\ModelInterface;

interface DeviceDynamicFieldInterface extends ModelInterface
{
    /**
     * @return DeviceDynamicFieldId
     */
    public function getId(): DeviceDynamicFieldId;

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId;

    /**
     * @return string
     */
    public function getName(): string;
}
