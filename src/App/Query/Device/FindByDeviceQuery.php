<?php

namespace App\App\Query\Device;

use App\Core\Model\Device\DeviceId;

abstract class FindByDeviceQuery
{
    /** @var DeviceId  */
    private $id;

    /**
     * FindByIdQuery constructor.
     * @param DeviceId $id
     */
    public function __construct(DeviceId $id)
    {
        $this->id = $id;
    }

    /**
     * @return DeviceId
     */
    public function getId(): DeviceId
    {
        return $this->id;
    }
}
