<?php

namespace App\Core\Model\Item\ItemType;

use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class ItemTypeId extends ModelStringId
{
    /**
     * ItemTypeId constructor.
     * @param string $value
     * @throws InvalidItemTypeIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidItemTypeIdException();
        }
    }
}