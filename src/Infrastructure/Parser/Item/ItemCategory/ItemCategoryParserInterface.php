<?php

namespace App\Infrastructure\Parser\Item\ItemCategory;

use APP\App\Query\Item\AllListGroupedByCategoryQuery;

interface ItemCategoryParserInterface
{
    /**
     * @param bool $withDevice
     * @return AllListGroupedByCategoryQuery
     */
    public function parse(bool $withDevice): AllListGroupedByCategoryQuery;
}
