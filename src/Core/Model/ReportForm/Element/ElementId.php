<?php

namespace App\Core\Model\ReportForm\Element;

use App\Core\Model\Exception\InvalidElementIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class ElementId extends ModelId
{
    /**
     * ElementId constructor.
     * @param string $value
     * @throws InvalidElementIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidElementIdException('Invalid ElementId given');
        }
    }
}
