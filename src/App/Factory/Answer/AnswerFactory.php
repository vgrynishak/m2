<?php

namespace App\App\Factory\Answer;

use App\Core\Model\Answer\Answer;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessment;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessmentId;
use App\Core\Model\Answer\AnswerId;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Exception\InvalidAnswerAssessmentIdException;

class AnswerFactory implements AnswerFactoryInterface
{
    /**
     * @param AnswerId $id
     * @param ItemId $itemId
     * @param string $value
     * @param int $position
     * @param string $assessment
     * @return Answer
     * @throws InvalidAnswerAssessmentIdException
     */
    public function make(
        AnswerId $id,
        ItemId $itemId,
        string $value,
        int $position,
        $assessment = null
    ): Answer {
        $assessment = $assessment ?: AnswerAssessment::NONE;
        $answer = new Answer($id, $itemId, new AnswerAssessmentId($assessment));
        $answer->setValue($value);
        $answer->setPosition($position);

        return $answer;
    }
}