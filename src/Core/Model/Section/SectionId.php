<?php

namespace App\Core\Model\Section;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\ModelId;

class SectionId extends ModelId
{
    /**
     * SectionId constructor.
     * @param string $value
     * @throws InvalidSectionIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidSectionIdException("Invalid Section Id");
        }
    }
}
