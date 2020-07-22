<?php

namespace App\App\Query\Item;

use App\Components\Message\MessageInterface;
use App\App\Component\UUID\UUID;

class ItemCategoryQuery implements MessageInterface
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
