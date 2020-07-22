<?php

namespace App\Core\Model\Item\ItemCategory;

use App\Core\Model\ModelInterface;
use PhpCollection\CollectionInterface;

interface ItemCategoryInterface extends ModelInterface
{
    public function getId(): ItemCategoryId;

    public function getName(): string;

    public function setDescription(?string $description);

    public function getDescription(): ?string;

    public function setItemTypes(?CollectionInterface $itemTypes);

    public function getItemTypes(): ?CollectionInterface;

    public function setPosition(int $position): void;

    public function getPosition(): int;
}
