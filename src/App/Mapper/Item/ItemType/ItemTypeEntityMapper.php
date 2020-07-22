<?php

namespace App\App\Mapper\Item\ItemType;

use App\App\Doctrine\Entity\Item\ItemType as ItemTypeEntity;
use App\Core\Model\Item\ItemCategory\ItemCategoryId;
use App\Core\Model\Item\ItemType\ItemType;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidItemCategoryIdException;

class ItemTypeEntityMapper implements ItemTypeEntityMapperInterface
{
    /**
     * @param ItemTypeEntity $itemTypeORM
     * @return ItemType
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     */
    public function map(ItemTypeEntity $itemTypeORM): ItemType
    {
        if (!$itemTypeORM instanceof ItemTypeEntity) {
            return null;
        }

        $itemType = new ItemType(
            new ItemTypeId($itemTypeORM->getId()),
            new ItemCategoryId($itemTypeORM->getItemCategory()->getId()),
            $itemTypeORM->getName()
        );

        $itemType->setDescription($itemTypeORM->getDescription());
        $itemType->setPosition($itemTypeORM->getPosition());

        return $itemType;
    }

    /**
     * @param array $itemTypeEntities
     *
     * @return array
     *
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     */
    public function mapArray(array $itemTypeEntities): array
    {
        $itemTypesResult = [];
        foreach ($itemTypeEntities as $itemTypeEntity) {
            $itemTypesResult[] = $this->map($itemTypeEntity);
        }

        return $itemTypesResult;
    }
}
