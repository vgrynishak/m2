<?php

namespace App\Infrastructure\Adapter\Item\ItemCategory;

use App\Core\Model\Item\ItemCategory\ItemCategory;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Adapter\DTO\Item\ItemCategory\Full as FullItemCategoryDTO;
use App\Infrastructure\Adapter\DTO\Item\ItemType\ShortForItemCategory;
use PhpCollection\CollectionInterface;

class Full
{
    public static function adapt(ItemCategory $itemCategory): FullItemCategoryDTO
    {
        $itemCategoryDTO = new FullItemCategoryDTO(
            $itemCategory->getId()->getValue(),
            $itemCategory->getName(),
            $itemCategory->getPosition()
        );

        $itemCategoryDTO->setItemTypes(self::getItemTypes($itemCategory));

        return $itemCategoryDTO;
    }

    /**
     * @param CollectionInterface $itemCategoryCollection
     * @return array
     */
    public static function adaptCollection(CollectionInterface $itemCategoryCollection): array
    {
        /** @var  FullItemCategoryDto[] $resultItemCategories */
        $resultItemCategories = [];

        foreach ($itemCategoryCollection as $itemCategory) {
            $resultItemCategories[] = self::adapt($itemCategory);
        }

        return $resultItemCategories;
    }

    /**
     * @param ItemCategory $itemCategory
     * @return array
     */
    public static function getItemTypes(ItemCategory $itemCategory) : array
    {
        $itemTypes = [];

        /** @var ItemType $itemType */
        foreach ($itemCategory->getItemTypes() as $itemType) {
            $itemTypes[] = new ShortForItemCategory(
                $itemType->getId()->getValue(),
                $itemType->getName(),
                $itemType->getPosition()
            );
        }

        return $itemTypes;
    }
}
