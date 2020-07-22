<?php

namespace App\App\Doctrine\Mapper\Item;

use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\Core\Model\Item\ItemInterface;

interface ItemMapperInterface
{
    /**
     * @param ItemInterface $item
     * @return Item
     * @throws NonExistentEntity
     */
    public function map(ItemInterface $item) : Item;

    /**
     * @param ItemInterface $item
     * @return Item
     * @throws NonExistentEntity
     */
    public function mapNew(ItemInterface $item) :Item;
}