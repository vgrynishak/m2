<?php

namespace App\Core\Model\Item\ItemCategory;

use App\Core\Model\Exception\InvalidItemCategoryIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class ItemCategoryId extends ModelStringId
{
    /**
     * ItemCategoryId constructor.
     * @param string $value
     * @throws InvalidItemCategoryIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidItemCategoryIdException();
        }
    }
}