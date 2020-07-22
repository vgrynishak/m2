<?php

namespace App\App\Repository\Item\ItemType;

use App\Core\Model\Item\ItemCategory\ItemCategory;
use App\Core\Model\Item\ItemType\ItemType;
use App\App\Doctrine\Entity\Item\ItemType as itemTypeEntity;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\App\Mapper\Item\ItemType\ItemTypeEntityMapperInterface;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Item\ItemType\ItemTypeInterface;
use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Repository\Item\ItemCategory\ItemCategoryQueryRepositoryInterface;
use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class ItemTypeQueryRepository implements ItemTypeQueryRepositoryInterface
{
    public const EXCLUDED_ITEM_TYPES_FOR_PARAGRAPH_WITHOUT_DEVICE = [
        ItemType::COMMENTS_WITH_DEFICIENCY,
        ItemType::INFORMATION_DEVICE_RELATED
    ];

    /** @var ItemTypeRepository */
    private $itemTypeRepository;
    /** @var ItemTypeEntityMapperInterface */
    private $itemTypeMapper;
    /** @var ItemCategoryQueryRepositoryInterface */
    private $itemCategoryQueryRepository;

    /**
     * ItemCategoryQueryRepository constructor.
     * @param ItemTypeRepository $itemTypeRepository
     * @param ItemTypeEntityMapperInterface $itemTypeMapper
     * @param ItemCategoryQueryRepositoryInterface $itemCategoryQueryRepository
     */
    public function __construct(
        ItemTypeRepository $itemTypeRepository,
        ItemTypeEntityMapperInterface $itemTypeMapper,
        ItemCategoryQueryRepositoryInterface $itemCategoryQueryRepository
    ) {
        $this->itemTypeRepository = $itemTypeRepository;
        $this->itemTypeMapper = $itemTypeMapper;
        $this->itemCategoryQueryRepository = $itemCategoryQueryRepository;
    }

    /**
     * @param ItemTypeId $id
     * @return ItemTypeInterface
     * @throws InvalidItemCategoryIdException
     * @throws InvalidItemTypeIdException
     */
    public function find(ItemTypeId $id): ?ItemTypeInterface
    {
        $itemType = $this->itemTypeRepository->find($id->getValue());

        if (!$itemType instanceof ItemTypeEntity) {
            return null;
        }

        return $this->itemTypeMapper->map($itemType);
    }

    /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     */
    public function findAll(): CollectionInterface
    {
        /** @var ItemType[] $allItemTypes */
        $allItemTypeEntities = $this->itemTypeRepository->findAll();

        return $this->mapAndGrouped($allItemTypeEntities);
    }

    /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     */
    public function findAllForParagraphWithoutDevice(): CollectionInterface
    {
        /** @var ItemType[] $allItemTypes */
        $allItemTypeEntities = $this->itemTypeRepository->findAllExcepted(
            self::EXCLUDED_ITEM_TYPES_FOR_PARAGRAPH_WITHOUT_DEVICE
        );

        return $this->mapAndGrouped($allItemTypeEntities);
    }

    /**
     * @param array $allItemTypeEntities
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     */
    private function mapAndGrouped(array $allItemTypeEntities): CollectionInterface
    {
        $ItemTypeModels = $this->itemTypeMapper->mapArray($allItemTypeEntities);

        return $this->groupedByCategories($ItemTypeModels, $this->itemCategoryQueryRepository->findAll());
    }

    /**
     * @param array $itemTypes
     *
     * @param CollectionInterface $categories
     * @return CollectionInterface
     */
    private function groupedByCategories(array $itemTypes, CollectionInterface $categories): CollectionInterface
    {
        $groupedItemTypes = [];
        /** @var ItemType $itemType */
        foreach ($itemTypes as $itemType) {
            $groupedItemTypes[$itemType->getItemCategoryId()->getValue()][] = $itemType;
        }

        /** @var ItemCategory $category */
        foreach ($categories as $category) {
            $category->setItemTypes(
                $this->sortItemTypeByPosition(new Set($groupedItemTypes[$category->getId()->getValue()]))
            );
        }

        return $categories;
    }

    /**
     * @param CollectionInterface $itemTypes
     * @return Set
     */
    private function sortItemTypeByPosition(CollectionInterface $itemTypes): Set
    {
        $itemTypeModels = $itemTypes->all();

        usort($itemTypeModels, static function ($firstElement, $secondElement) {
            if ($firstElement->getPosition() === $secondElement->getPosition()) {
                return 0;
            }

            return $firstElement->getPosition() > $secondElement->getPosition() ? 1: -1;
        });

        return new Set($itemTypeModels);
    }
}
