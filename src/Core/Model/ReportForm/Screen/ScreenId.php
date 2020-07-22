<?php

namespace App\Core\Model\ReportForm\Screen;

use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\Exception\InvalidScreenIdException;
use App\Core\Model\ModelId;

class ScreenId extends ModelId
{
    /**
     * ScreenId constructor.
     * @param string $value
     * @throws InvalidScreenIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidScreenIdException('Invalid ScreenId given');
        }
    }
}
