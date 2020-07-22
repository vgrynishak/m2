<?php

namespace App\App\Mapper\Item\ItemType;

use App\App\Doctrine\Entity\Item\ItemType as ItemTypeEntity;
use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Item\ItemType\ItemType;

interface ItemTypeEntityMapperInterface
{
    /**
     * @param ItemTypeEntity $itemTypeORM
     * @return ItemType
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     */
    public function map(ItemTypeEntity $itemTypeORM): ItemType;

    /**
     * @param array $itemTypes
     * @return array
     */
    public function mapArray(array $itemTypes): array;
}
