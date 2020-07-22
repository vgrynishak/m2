<?php

namespace App\Core\Model\Item\InformationItem\Dictionary;

use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class DictionaryId extends ModelStringId
{
    /**
     * DictionaryId constructor.
     * @param string $value
     * @throws InvalidDictionaryIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidDictionaryIdException('Invalid DictionaryId given');
        }
    }
}
