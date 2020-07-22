<?php

namespace App\Core\Model\Item\Base;

use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Model\Item\ItemType\ItemTypeInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface as Paragraph;
use App\Core\Model\Paragraph\ParagraphId;
use DateTime;

abstract class BaseItem implements ItemInterface
{
    /** @var ItemId */
    private $id;
    /** @var ParagraphId */
    private $paragraph;
    /** @var int */
    private $position;
    /** @var ItemTypeInterface */
    private $itemType;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var bool */
    private $printable;

    /**
     * Item constructor.
     * @param ItemId $id
     * @param ParagraphId $paragraph
     * @param ItemTypeInterface $itemType
     */
    public function __construct(
        ItemId $id,
        ParagraphId $paragraph,
        ItemTypeInterface $itemType
    ) {
        $this->id = $id;
        $this->paragraph = $paragraph;
        $this->itemType = $itemType;
    }

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
     * @return ItemTypeInterface
     */
    public function getItemType(): ItemTypeInterface
    {
        return $this->itemType;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setPrintable(?bool $printable): void
    {
        $this->printable = $printable;
    }

    public function getPrintable(): ?bool
    {
        return $this->printable ?? true;
    }
}
