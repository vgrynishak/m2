<?php

namespace App\Core\Repository\Item\ItemCategory;

use App\Core\Model\Exception\InvalidItemCategoryIdException;
use PhpCollection\CollectionInterface;

interface ItemCategoryQueryRepositoryInterface
{
    /**
     * /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     */
    public function findAll(): CollectionInterface;
}
