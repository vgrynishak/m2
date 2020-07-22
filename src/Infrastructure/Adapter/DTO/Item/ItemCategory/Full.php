<?php

namespace App\Infrastructure\Adapter\DTO\Item\ItemCategory;

use App\Infrastructure\Adapter\DTO\Item\ItemType\ShortForItemCategory;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var int */
    private $position;
    /** @var ShortForItemCategory[] */
    private $itemTypes;

    public function __construct(string $id, string $name, int $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
    }

    public function setItemTypes(array $itemTypes)
    {
        $this->itemTypes = $itemTypes;
    }
}
