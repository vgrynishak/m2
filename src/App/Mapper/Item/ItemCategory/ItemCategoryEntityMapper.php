<?php

namespace App\App\Mapper\Item\ItemCategory;

use App\App\Doctrine\Entity\Item\ItemCategory as ItemCategoryEntity;
use App\Core\Model\Item\ItemCategory\ItemCategory;
use App\Core\Model\Item\ItemCategory\ItemCategoryId;
use App\Core\Model\Exception\InvalidItemCategoryIdException;

class ItemCategoryEntityMapper implements ItemCategoryEntityMapperInterface
{
    /**
     * @param ItemCategoryEntity $itemCategoryORM
     * @return ItemCategory
     * @throws InvalidItemCategoryIdException
     * @throws \Exception
     */
    public function map(ItemCategoryEntity $itemCategoryORM): ItemCategory
    {
        if (!$itemCategoryORM instanceof ItemCategoryEntity) {
            return null;
        }

        $itemCategory = new ItemCategory(
            new ItemCategoryId($itemCategoryORM->getId()),
            $itemCategoryORM->getName()
        );

        $itemCategory->setDescription($itemCategoryORM->getDescription());
        $itemCategory->setPosition($itemCategoryORM->getPosition());

        return $itemCategory;
    }
}
