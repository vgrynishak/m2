<?php

namespace App\Core\Repository\Item\ItemType;

use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Item\ItemType\ItemTypeInterface;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Infrastructure\Exception\Item\FailGetListItemType;
use PhpCollection\CollectionInterface;

interface ItemTypeQueryRepositoryInterface
{
    /**
     * @param ItemTypeId $id
     * @return ItemTypeInterface
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     */
    public function find(ItemTypeId $id): ?ItemTypeInterface;

    /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     * @throws FailGetListItemType
     */
    public function findAll(): CollectionInterface;

    /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     * @throws FailGetListItemType
     */
    public function findAllForParagraphWithoutDevice(): CollectionInterface;
}
