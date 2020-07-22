<?php

namespace App\App\Repository\Item;

use App\App\Doctrine\Entity\Item\Item as ItemEntity;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Factory\Exception\FailMakeItemModel;
use App\App\Mapper\Item\ItemEntityMapperInterface;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class ItemQueryRepository implements ItemQueryRepositoryInterface
{
    /** @var ItemRepository */
    private $itemRepository;

    /** @var ItemEntityMapperInterface */
    private $mapper;

    public function __construct(ItemRepository $itemRepository, ItemEntityMapperInterface $mapper)
    {
        $this->itemRepository = $itemRepository;
        $this->mapper = $mapper;
    }

    /**
     * @param ParagraphId $paragraphId
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPosition(ParagraphId $paragraphId): int
    {
        return  $this->itemRepository->getMaxPosition($paragraphId);
    }

    /**
     * @param ParagraphId $paragraphId
     * @return CollectionInterface|null
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function findListByParagraphId(ParagraphId $paragraphId): ?CollectionInterface
    {
        $allItemsEntity = $this->itemRepository->findByParagraphIdSortedByPosition($paragraphId);

        $resultItemsModel = [];

        foreach ($allItemsEntity as $itemEntity) {
            $resultItemsModel[] = $this->mapper->map($itemEntity);
        }

        return new Set($resultItemsModel);
    }

    /**
     * @param ItemId $itemId
     * @return ItemInterface|null
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function find(ItemId $itemId): ?ItemInterface
    {
        /** @var ItemEntity $itemEntity */
        $itemEntity = $this->itemRepository->find($itemId->getValue());

        if (!$itemEntity instanceof ItemEntity) {
            return null;
        }

        return $this->mapper->map($itemEntity);
    }
}
