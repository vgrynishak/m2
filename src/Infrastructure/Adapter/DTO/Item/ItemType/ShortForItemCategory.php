<?php

namespace App\Infrastructure\Adapter\DTO\Item\ItemType;

class ShortForItemCategory
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var int */
    private $position;

    /**
     * ShortForItemCategory constructor.
     * @param string $id
     * @param string $name
     * @param int $position
     */
    public function __construct(string $id, string $name, int $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
    }
}
