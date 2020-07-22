<?php

namespace App\Core\Repository\Item;

use App\App\Repository\Exception\FailCreateItemException;
use App\App\Repository\Exception\FailUpdateItemException;
use App\Core\Model\Item\ItemInterface;
use PhpCollection\CollectionInterface;

interface ItemCommandRepositoryInterface
{
    /**
     * @param ItemInterface $item
     * @throws FailCreateItemException
     */
    public function create(ItemInterface $item): void;

    /**
     * @param ItemInterface $item
     * @throws FailUpdateItemException
     */
    public function update(ItemInterface $item): void;

    /**
     * @param CollectionInterface $items
     */
    public function deleteList(CollectionInterface $items): void;

    /**
     * @param ItemInterface $item
     * @param int $newPosition
     * @return mixed
     * @throws \Exception
     */
    public function changePosition(ItemInterface $item, int $newPosition);
}
