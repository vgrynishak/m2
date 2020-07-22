<?php

namespace App\App\Mapper\Item\ItemCategory;

use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Item\ItemCategory\ItemCategory;
use App\App\Doctrine\Entity\Item\ItemCategory as ItemCategoryEntity;

interface ItemCategoryEntityMapperInterface
{
    /**
     * @param ItemCategoryEntity $itemCategoryORM
     * @return ItemCategory
     * @throws InvalidItemCategoryIdException
     * @throws \Exception
     */
    public function map(ItemCategoryEntity $itemCategoryORM) :ItemCategory;
}