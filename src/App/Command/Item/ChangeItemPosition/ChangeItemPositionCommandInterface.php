<?php

namespace App\App\Command\Item\ChangeItemPosition;

use App\Core\Model\Item\ItemId;

interface ChangeItemPositionCommandInterface
{
    /**
     * @return ItemId
     */
    public function getId(): ItemId;

    /**
     * @return int
     */
    public function getNewPosition(): int;
}
