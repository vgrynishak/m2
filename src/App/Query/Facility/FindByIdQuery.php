<?php

namespace App\App\Query\Facility;

use App\Components\Message\MessageInterface;
use App\App\Component\UUID\UUID;

class FindByIdQuery implements MessageInterface
{
    /** @var UUID */
    private $id;

    /**
     * DeviceQuery constructor.
     * @param UUID $id
     */
    public function __construct(UUID $id)
    {
        $this->id = $id;
    }

    /**
     * @return UUID
     */
    public function getId(): UUID
    {
        return $this->id;
    }
}
