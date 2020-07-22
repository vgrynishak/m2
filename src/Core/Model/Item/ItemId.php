<?php

namespace App\Core\Model\Item;

use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class ItemId extends ModelId
{
    /**
     * ItemId constructor.
     * @param string $value
     * @throws InvalidItemIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidItemIdException('Invalid ItemId given');
        }
    }
}