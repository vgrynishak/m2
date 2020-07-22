<?php

namespace App\App\Doctrine\Mapper\Item;

use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\App\Doctrine\Repository\ParagraphRepository;
use App\Core\Model\Item\Base\InfoSourceInterface;
use App\Core\Model\Item\Base\LabelInterface;
use App\Core\Model\Item\Base\NFPAInterface;
use App\Core\Model\Item\Base\PlaceholderInterface;
use App\Core\Model\Item\Base\RememberInterface;
use App\Core\Model\Item\Base\RequireInterface;
use App\Core\Model\Item\ItemInterface;

class ItemMapper implements ItemMapperInterface
{
    /** @var ItemRepository */
    private $itemRepository;
    /** @var ParagraphRepository */
    private $paragraphRepository;
    /** @var ItemTypeRepository */
    private $itemTypeRepository;

    public function __construct(
        ItemRepository $itemRepository,
        ParagraphRepository $paragraphRepository,
        ItemTypeRepository $itemTypeRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->paragraphRepository = $paragraphRepository;
        $this->itemTypeRepository = $itemTypeRepository;
    }

    /**
     * @param ItemInterface $item
     * @return Item
     * @throws NonExistentEntity
     */
    public function map(ItemInterface $item): Item
    {
        /** @var Item $itemEntity */
        $itemEntity = $this->itemRepository->find($item->getId()->getValue());

        if (!$itemEntity) {
            throw new NonExistentEntity('Item Entity not exist');
        }

        return $this->fillBaseItem($itemEntity, $item);
    }

    /**
     * @param ItemInterface $item
     * @return Item
     * @throws NonExistentEntity
     */
    public function mapNew(ItemInterface $item): Item
    {
        /** @var Item $itemEntity */
        $itemEntity = new Item();
        $itemEntity
            ->setId($item->getId()->getValue())
            ->setCreatedAt($item->getCreatedAt())
            ->setPosition($item->getPosition())
            ;

        return $this->fillBaseItem($itemEntity, $item);
    }

    /**
     * @param Item $itemEntity
     * @param ItemInterface $item
     * @return Item
     * @throws NonExistentEntity
     */
    private function fillBaseItem(Item $itemEntity, ItemInterface $item): Item
    {
        $paragraphEntity = $this->paragraphRepository->find($item->getParagraphId()->getValue());

        if (!$paragraphEntity) {
            throw new NonExistentEntity('Paragraph Entity not exist');
        }

        $itemTypeEntity = $this->itemTypeRepository->find($item->getItemType()->getId()->getValue());

        if (!$itemTypeEntity) {
            throw new NonExistentEntity('ItemType Entity not exist');
        }

        $itemEntity
            ->setParagraphId($paragraphEntity)
            ->setItemTypeId($itemTypeEntity)
            ->setUpdatedAt($item->getUpdatedAt())
            ->setPrintable($item->getPrintable())
        ;

        if ($item instanceof LabelInterface) {
            $itemEntity->setLabel($item->getLabel());
        }
        if ($item instanceof NFPAInterface) {
            $itemEntity->setNFPARef($item->getNFPA());
        }
        if ($item instanceof PlaceholderInterface) {
            $itemEntity->setPlaceholder($item->getPlaceholder());
        }
        if ($item instanceof RequireInterface) {
            $itemEntity->setRequired($item->getRequire());
        }
        if ($item instanceof RememberInterface) {
            $itemEntity->setRemembered($item->getRemember());
        }

        return $itemEntity;
    }
}
