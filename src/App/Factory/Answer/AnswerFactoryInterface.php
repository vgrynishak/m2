<?php

namespace App\App\Factory\Answer;

use App\Core\Model\Answer\Answer;
use App\Core\Model\Answer\AnswerAssessment\AnswerAssessment;
use App\Core\Model\Answer\AnswerId;
use App\Core\Model\Exception\InvalidAnswerAssessmentIdException;
use App\Core\Model\Item\ItemId;

interface AnswerFactoryInterface
{
    /**
     * @param AnswerId $id
     * @param ItemId $itemId
     * @param string $value
     * @param int $position
     * @param string $assessment
     * @return Answer
     */
    public function make(
        AnswerId $id,
        ItemId $itemId,
        string $value,
        int $position,
        $assessment = AnswerAssessment::NONE
    ): Answer;
}