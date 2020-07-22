<?php

namespace App\App\Repository\Item\ItemCategory;

use App\App\Doctrine\Repository\Item\ItemCategoryRepository;
use App\App\Mapper\Item\ItemCategory\ItemCategoryEntityMapperInterface;
use App\Core\Repository\Item\ItemCategory\ItemCategoryQueryRepositoryInterface;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use App\Core\Model\Exception\InvalidItemCategoryIdException;

class ItemCategoryQueryRepository implements ItemCategoryQueryRepositoryInterface
{
    /** @var ItemCategoryEntityMapperInterface */
    private $itemCategoryMapper;

    /** @var ItemCategoryRepository */
    private $itemCategoryRepository;

    /**
     * ItemCategoryQueryRepository constructor.
     * @param ItemCategoryRepository $itemCategoryRepository
     * @param ItemCategoryEntityMapperInterface $itemCategoryMapper
     */
    public function __construct(
        ItemCategoryRepository $itemCategoryRepository,
        ItemCategoryEntityMapperInterface $itemCategoryMapper
    ) {
        $this->itemCategoryRepository = $itemCategoryRepository;
        $this->itemCategoryMapper = $itemCategoryMapper;
    }

    /**
     * @return CollectionInterface
     * @throws InvalidItemCategoryIdException
     */
    public function findAll(): CollectionInterface
    {
        $categories = $this->itemCategoryRepository->findAllSortedByPosition();

        foreach ($categories as $category) {
            $categoriesModel[] = $this->itemCategoryMapper->map($category);
        }

        return new Set($categoriesModel ?? []);
    }
}
