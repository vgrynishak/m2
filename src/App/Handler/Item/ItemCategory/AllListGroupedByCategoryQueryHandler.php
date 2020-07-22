<?php

namespace App\App\Handler\Item\ItemCategory;

use App\App\Query\Item\AllListGroupedByCategoryQuery;
use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;
use App\Infrastructure\Exception\Item\FailGetListItemType;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use PhpCollection\CollectionInterface;

class AllListGroupedByCategoryQueryHandler implements MessageHandlerInterface
{
    /** @var ItemTypeQueryRepositoryInterface */
    private $itemTypeQueryRepository;


    /**
     * AllListGroupedByCategoryQueryHandler constructor.
     *
     * @param ItemTypeQueryRepositoryInterface $itemTypeQueryRepository
     */
    public function __construct(ItemTypeQueryRepositoryInterface $itemTypeQueryRepository)
    {
        $this->itemTypeQueryRepository = $itemTypeQueryRepository;
    }

    /**
     * @param AllListGroupedByCategoryQuery $query
     * @return CollectionInterface
     * @throws FailGetListItemType
     */
    public function __invoke(AllListGroupedByCategoryQuery $query)
    {
        try {
            if ($query->withDevice()) {
                return $this->itemTypeQueryRepository->findAll();
            }

            return $this->itemTypeQueryRepository->findAllForParagraphWithoutDevice();
        } catch (\Exception $e) {
            throw new FailGetListItemType($e->getMessage());
        }
    }
}
