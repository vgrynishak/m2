<?php

namespace App\App\Doctrine\Mapper\Answer;

use App\App\Doctrine\Entity\Answer as AnswerEntity;
use App\App\Doctrine\Entity\Item\AnswerAssessment as AnswerAssessmentEntity;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\App\Doctrine\Repository\AnswerRepository;
use App\App\Doctrine\Repository\Item\AnswerAssessmentRepository;
use App\Core\Model\Answer\AnswerInterface;

class AnswerMapper implements AnswerMapperInterface
{
    /** @var AnswerAssessmentRepository */
    private $answerAssessmentRepository;

    /** @var AnswerRepository */
    private $answerRepository;

    /**
     * AnswerMapper constructor.
     * @param AnswerAssessmentRepository $answerAssessmentRepository
     * @param AnswerRepository $answerRepository
     */
    public function __construct(
        AnswerAssessmentRepository $answerAssessmentRepository,
        AnswerRepository $answerRepository
    ) {
        $this->answerAssessmentRepository = $answerAssessmentRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * @inheritDoc
     */
    public function map(AnswerInterface $answer): AnswerEntity
    {
        $answerEntity = $this->answerRepository->find($answer->getId()->getValue());

        if (!$answerEntity instanceof AnswerEntity) {
            throw new NonExistentEntity('Answer Entity not exist');
        }

        return $this->fillBaseAnswerEntity($answerEntity, $answer);
    }

    /**
     * @inheritDoc
     */
    public function mapNew(AnswerInterface $answer): AnswerEntity
    {
        $answerEntity = new AnswerEntity();

        $answerEntity->setId($answer->getId()->getValue());

        return $this->fillBaseAnswerEntity($answerEntity, $answer);
    }

    /**
     * @param AnswerEntity $answerEntity
     * @param AnswerInterface $answer
     * @return AnswerEntity
     * @throws NonExistentEntity
     */
    private function fillBaseAnswerEntity(AnswerEntity $answerEntity, AnswerInterface $answer): AnswerEntity
    {
        $answerAssessmentEntity = $this->answerAssessmentRepository->find($answer->getAssessment()->getValue());

        if (!$answerAssessmentEntity instanceof AnswerAssessmentEntity) {
            throw new NonExistentEntity('AnswerAssessment Entity not exist');
        }

        $answerEntity
            ->setPosition($answer->getPosition())
            ->setText($answer->getValue())
            ->setAssessment($answerAssessmentEntity)
        ;

        return $answerEntity;
    }
}
