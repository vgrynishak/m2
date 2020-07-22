<?php

namespace App\Core\Model\Item\ItemType;

use App\Core\Model\Item\ItemCategory\ItemCategoryId;
use App\Core\Model\ModelInterface;

interface ItemTypeInterface extends ModelInterface
{
    public function getId(): ItemTypeId;

    public function getItemCategoryId(): ItemCategoryId;

    public function getName(): string;

    public function setDescription(?string $description);

    public function getDescription(): ?string;

    public function setPosition(int $position): void;

    public function getPosition(): int;
}
