<?php

namespace App\App\Factory\Item;

use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Paragraph\ParagraphId;

interface ItemFactoryInterface
{
    /**
     * @param ItemId $id
     * @param ParagraphId $paragraphId
     * @param ItemTypeId $itemTypeId
     * @return ItemInterface
     * @throws FailMakeItemModel
     */
    public function make(ItemId $id, ParagraphId $paragraphId, ItemTypeId $itemTypeId): ItemInterface;
}
