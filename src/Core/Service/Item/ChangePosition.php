<?php

namespace App\Core\Service\Item;

use App\App\Doctrine\Entity\Item\Item as ItemEntity;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\Core\Model\Item\ItemInterface;

class ChangePosition implements ChangePositionInterface
{
    /** @var ItemRepository */
    private $itemRepository;

    /**
     * ChangePosition constructor.
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @inheritDoc
     */
    public function decreaseItemListInPosition(ItemInterface $item, int $positionToChange): void
    {
        /** @var ItemEntity[] $itemsEntity */
        $itemsEntity = $this->itemRepository->getListWhoNeedDecreaseInPosition($item, $positionToChange);
        /** @var ItemEntity $itemEntity */
        foreach ($itemsEntity as $itemEntity) {
            $itemEntity
                ->setPosition($itemEntity->getPosition() - 1)
                ->setUpdatedAt(new \DateTime())
            ;
        }
    }

    /**
     * @inheritDoc
     */
    public function increaseItemListInPosition(ItemInterface $item, int $positionToChange): void
    {
        /** @var ItemEntity[] $itemsEntity */
        $itemsEntity = $this->itemRepository->getListWhoNeedIncreaseInPosition($item, $positionToChange);
        /** @var ItemEntity $itemEntity */
        foreach ($itemsEntity as $itemEntity) {
            $itemEntity
                ->setPosition($itemEntity->getPosition() + 1)
                ->setUpdatedAt(new \DateTime())
            ;
        }
    }
}
