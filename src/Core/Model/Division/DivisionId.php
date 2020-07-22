<?php

namespace App\Core\Model\Division;

use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class DivisionId extends ModelId
{
    /**
     * DivisionId constructor.
     * @param string $value
     * @throws InvalidDivisionIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidDivisionIdException();
        }
    }
}
