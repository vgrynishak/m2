<?php

namespace App\Core\Service\Item;

use App\Core\Model\Item\ItemInterface;

interface ChangePositionInterface
{
    /**
     * @param ItemInterface $item
     * @param int $positionToChange
     */
    public function decreaseItemListInPosition(ItemInterface $item, int $positionToChange): void;

    /**
     * @param ItemInterface $item
     * @param int $positionToChange
     */
    public function increaseItemListInPosition(ItemInterface $item, int $positionToChange): void;
}
