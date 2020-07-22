<?php

namespace App\Core\Model\Answer\AnswerAssessment;

use App\Core\Model\Exception\InvalidAnswerAssessmentIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelStringId;

class AnswerAssessmentId extends ModelStringId
{
    /**
     * AnswerAssessmentId constructor.
     * @param string $value
     * @throws InvalidAnswerAssessmentIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidAnswerAssessmentIdException();
        }
    }
}