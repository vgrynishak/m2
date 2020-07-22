<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\ModelId;
use App\Core\Model\Exception\InvalidModelIdException;

class ParagraphId extends ModelId
{
    /**
     * ParagraphId constructor.
     * @param string $value
     * @throws InvalidParagraphIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidParagraphIdException("Invalid Paragraph Id");
        }
    }
}
