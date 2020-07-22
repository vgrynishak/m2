<?php

namespace App\Core\Model\Item\InformationItem\InfoSource;

use App\Core\Model\Exception\InvalidInfoSourceIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class InfoSourceId extends ModelStringId
{
    /**
     * InfoSourceId constructor.
     * @param string $value
     * @throws InvalidInfoSourceIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidInfoSourceIdException('Invalid InfoSourceId given');
        }
    }
}
