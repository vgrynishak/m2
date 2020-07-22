<?php

namespace App\Core\Model\DeviceDynamicField;

use App\Core\Model\Device\DeviceId;

class DeviceDynamicField implements DeviceDynamicFieldInterface
{
    /** @var DeviceDynamicFieldId */
    private $id;
    /** @var DeviceId */
    private $deviceId;
    /** @var string */
    private $name;

    /**
     * InfoSource constructor.
     * @param DeviceDynamicFieldId $id
     * @param DeviceId $deviceId
     * @param string $name
     */
    public function __construct(DeviceDynamicFieldId $id, DeviceId $deviceId, string $name)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->name = $name;
    }

    /**
     * @return DeviceDynamicFieldId
     */
    public function getId(): DeviceDynamicFieldId
    {
        return $this->id;
    }

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId
    {
        return $this->deviceId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
