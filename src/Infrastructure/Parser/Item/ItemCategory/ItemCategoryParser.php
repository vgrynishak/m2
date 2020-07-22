<?php

namespace App\Infrastructure\Parser\Item\ItemCategory;

use App\App\Query\Item\AllListGroupedByCategoryQuery;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;

class ItemCategoryParser implements ItemCategoryParserInterface
{
    /** @var UserQueryRepositoryInterface  */
    private $userQueryRepository;

    /**
     * ItemCategoryParser constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(UserQueryRepositoryInterface $userQueryRepository)
    {
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @param bool $withDevice
     * @return AllListGroupedByCategoryQuery
     */
    public function parse(bool $withDevice): AllListGroupedByCategoryQuery
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->getUserFromToken();

        return new AllListGroupedByCategoryQuery($withDevice, $user);
    }
}
