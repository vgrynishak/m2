<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Factory\Answer\AnswerFactoryInterface;
use App\Core\Model\Answer\AnswerId;
use App\Core\Model\Item\ItemId;
use InvalidArgumentException;
use App\Core\Model\Exception\InvalidAnswerIdException;
use App\Core\Model\Answer\Answer;

abstract class BaseAnswerParser
{
    /** @var  AnswerFactoryInterface */
    private $answerFactory;

    /**
     * CreateInputItemParser constructor.
     * @param AnswerFactoryInterface $answerFactory
     */
    public function __construct(AnswerFactoryInterface $answerFactory)
    {
        $this->answerFactory = $answerFactory;
    }

    /**
     * @param ItemId $itemId
     * @param $answer
     * @param int $position
     * @return Answer
     * @throws InvalidAnswerIdException
     */
    public function parseAnswer(ItemId $itemId, $answer, int $position): Answer
    {
        if (!is_array($answer)) {
            throw new InvalidArgumentException('answers should be array');
        }

        if (!array_key_exists('answerId', $answer)) {
            throw new InvalidArgumentException('answerId is required field in object answer');
        }

        if (!array_key_exists('value', $answer)) {
            throw new InvalidArgumentException('value is required field in object answer');
        }

        return $this->answerFactory->make(
            new AnswerId($answer['answerId']),
            $itemId,
            $answer['value'],
            $position,
            $answer['answerAssessment'] ?? null
        );
    }
}

