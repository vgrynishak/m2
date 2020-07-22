<?php

namespace App\App\Mapper\Item;

use App\App\Doctrine\Entity\Item\Item as ItemEntity;
use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Item\ItemInterface;

interface ItemEntityMapperInterface
{
    /**
     * @param ItemEntity $itemORM
     * @return null|ItemInterface
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function map(ItemEntity $itemORM): ?ItemInterface;
}
