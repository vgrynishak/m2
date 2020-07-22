<?php

namespace App\App\Mapper\Answer;

use App\App\Doctrine\Entity\Answer as AnswerEntity;
use App\Core\Model\Answer\AnswerInterface;

interface AnswerEntityMapperInterface
{
    /**
     * @param null|AnswerEntity $answerORM
     * @return null | AnswerInterface
     */
    public function map(?AnswerEntity $answerORM): ?AnswerInterface;
}
