<?php

namespace App\Core\Model\Item;

use App\Core\Model\Item\ItemType\ItemTypeInterface;
use App\Core\Model\ModelInterface;
use App\Core\Model\Paragraph\ParagraphId;
use DateTime;

interface ItemInterface extends ModelInterface
{
    public function getId() :ItemId;

    public function getParagraphId(): ParagraphId;

    public function getItemType(): ItemTypeInterface;

    public function getPosition(): ?int;

    public function setPosition(?int $position);

    public function getPrintable(): ?bool;

    public function setPrintable(?bool $printable);

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): DateTime;

    public function setUpdatedAt(DateTime $updatedAt): void;

    public function setCreatedAt(DateTime $createdAt): void;
}
