<?php

namespace App\App\Doctrine\Mapper\Answer;

use App\App\Doctrine\Entity\Answer as AnswerEntity;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\Core\Model\Answer\AnswerInterface;

interface AnswerMapperInterface
{
    /**
     * @param AnswerInterface $answer
     * @return AnswerEntity
     * @throws NonExistentEntity
     */
    public function map(AnswerInterface $answer) : AnswerEntity;

    /**
     * @param AnswerInterface $answer
     * @return AnswerEntity
     * @throws NonExistentEntity
     */
    public function mapNew(AnswerInterface $answer) :AnswerEntity;
}
