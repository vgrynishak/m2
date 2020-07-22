<?php

namespace App\App\Command\Item;

use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Paragraph\ParagraphId;

abstract class BaseItemCommand
{
    /** @var ItemId */
    private $id;
    /** @var ParagraphId */
    private $paragraph;
    /** @var ItemTypeId */
    private $itemTypeId;
    /** @var bool */
    private $printable;

    /**
     * @return ItemId
     */
    public function getId(): ItemId
    {
        return $this->id;
    }

    /**
     * @return ParagraphId
     */
    public function getParagraphId(): ParagraphId
    {
        return $this->paragraph;
    }

    /**
     * @return ItemTypeId
     */
    public function getItemTypeId(): ItemTypeId
    {
        return  $this->itemTypeId;
    }

    public function setId(ItemId $id): void
    {
        $this->id = $id;
    }

    public function setItemTypeId(ItemTypeId $itemTypeId): void
    {
        $this->itemTypeId = $itemTypeId;
    }

    /**
     * @param ParagraphId $paragraph
     */
    public function setParagraphId(ParagraphId $paragraph): void
    {
        $this->paragraph = $paragraph;
    }

    public function setPrintable(?bool $printable): void
    {
        $this->printable = $printable;
    }

    public function getPrintable(): ?bool
    {
        return $this->printable;
    }
}
