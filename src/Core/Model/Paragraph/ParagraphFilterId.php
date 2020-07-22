<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class ParagraphFilterId extends ModelStringId
{
    /**
     * ParagraphFilterId constructor.
     * @param string $value
     * @throws InvalidParagraphFilterIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidParagraphFilterIdException();
        }
    }
}
