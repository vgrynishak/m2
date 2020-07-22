<?php

namespace App\App\Query\Device;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;

class FindByIdQuery implements MessageInterface
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
