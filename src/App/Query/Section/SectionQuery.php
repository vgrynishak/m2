<?php

namespace App\App\Query\Section;

use App\Components\Message\MessageInterface;
use App\App\Component\UUID\UUID;

class SectionQuery implements MessageInterface
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
