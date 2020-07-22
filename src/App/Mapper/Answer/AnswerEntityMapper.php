<?php

namespace App\App\Mapper\Answer;

use App\App\Doctrine\Entity\Answer as AnswerEntity;
use App\App\Factory\Answer\AnswerFactoryInterface;
use App\Core\Model\Answer\AnswerId;
use App\Core\Model\Answer\AnswerInterface;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Exception\InvalidAnswerIdException;
use App\Core\Model\Exception\InvalidItemIdException;

class AnswerEntityMapper implements AnswerEntityMapperInterface
{
    /** @var AnswerFactoryInterface */
    private $answerFactory;

    public function __construct(AnswerFactoryInterface $answerFactory)
    {
        $this->answerFactory = $answerFactory;
    }

    /**
     * @param null|AnswerEntity $answerORM
     * @return null | AnswerInterface
     * @throws InvalidAnswerIdException
     * @throws InvalidItemIdException
     */
    public function map(?AnswerEntity $answerORM): ?AnswerInterface
    {
        if (!$answerORM instanceof AnswerEntity) {
            return null;
        }
        return $this->answerFactory->make(
            new AnswerId($answerORM->getId()),
            new ItemId($answerORM->getItem()->getId()),
            $answerORM->getText(),
            $answerORM->getPosition(),
            $answerORM->getAssessment()->getId()
        );
    }
}
