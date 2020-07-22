<?php

namespace App\Core\Model\Answer;

use App\Core\Model\Exception\InvalidAnswerIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class AnswerId extends ModelId
{
    /**
     * AnswerId constructor.
     * @param string $value
     * @throws InvalidAnswerIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $e) {
            throw  new InvalidAnswerIdException('Invalid AnswerId given');
        }
    }
}