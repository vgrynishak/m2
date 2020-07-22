<?php

namespace App\App\Command\Item;

use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Paragraph\ParagraphId;

interface BaseItemCommandInterface
{
    public function setId(ItemId $id);

    public function getId(): ItemId;

    public function setParagraphId(ParagraphId $paragraphId);

    public function getParagraphId(): ParagraphId;

    public function setItemTypeId(ItemTypeId $itemTypeId);

    public function getItemTypeId(): ItemTypeId;

    public function setPrintable(?bool $printable);

    public function getPrintable(): ?bool;
}
