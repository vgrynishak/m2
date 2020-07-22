<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\ModelId;
use App\Core\Model\Exception\InvalidModelIdException;

class StyleTemplateId extends ModelId
{
    /**
     * StyleTemplateId constructor.
     * @param string $value
     * @throws InvalidStyleTemplateIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidStyleTemplateIdException();
        }
    }
}
