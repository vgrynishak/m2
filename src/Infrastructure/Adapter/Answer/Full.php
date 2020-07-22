<?php

namespace App\Infrastructure\Adapter\Answer;

use App\Core\Model\Answer\AnswerInterface;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\DTO\Answer\Full as AnswerDTO;

class Full
{
    public static function adapt(AnswerInterface $answer): AnswerDTO
    {
        $answerDTO = new AnswerDTO(
            $answer->getId()->getValue(),
            $answer->getItemId()->getValue(),
            $answer->getAssessment()->getValue()
        );

        $answerDTO->setPosition($answer->getPosition());
        $answerDTO->setValue($answer->getValue());

        return $answerDTO;
    }

    public static function adaptCollection(CollectionInterface $answers): array
    {
        $result = [];

        /** @var AnswerInterface $answer */
        foreach ($answers as $answer) {
            $result[] = self::adapt($answer);
        }

        return  $result;
    }
}
