<?php

namespace App\Core\Model\Item\ItemCategory;

use Exception;
use PhpCollection\CollectionInterface;

class ItemCategory implements ItemCategoryInterface
{
    public const ITEM_CATEGORY_STATIC = 'static';
    public const ITEM_CATEGORY_INFORMATION = 'information';
    public const ITEM_CATEGORY_QUESTION = 'question';

    /** @var ItemCategoryId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var CollectionInterface */
    private $itemTypes;
    /** @var int */
    private $position;

    /**
     * ItemCategory constructor.
     * @param ItemCategoryId $id
     * @param string $name
     */
    public function __construct(
        ItemCategoryId $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return ItemCategoryId
     */
    public function getId(): ItemCategoryId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @param CollectionInterface|null $itemTypes
     */
    public function setItemTypes(?CollectionInterface $itemTypes)
    {
        $this->itemTypes = $itemTypes;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getItemTypes(): ?CollectionInterface
    {
        return $this->itemTypes;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
