<?php

namespace App\App\Command\Item\ChangeItemPosition;

use App\Core\Model\Item\ItemId;

class ChangeItemPositionCommand implements ChangeItemPositionCommandInterface
{
    /** @var ItemId */
    private $id;
    /** @var int */
    private $newPosition;
    
    public function __construct(ItemId $id, int $newPosition)
    {
        $this->id = $id;
        $this->newPosition = $newPosition;
    }

    /**
     * @inheritDoc
     */
    public function getId(): ItemId
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getNewPosition(): int
    {
        return $this->newPosition;
    }
}
