<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Command\Item\BaseItemCommandInterface;
use InvalidArgumentException;
use PhpCollection\Set;
use App\Core\Model\Exception\InvalidAnswerIdException;

class ListAnswerParser extends BaseAnswerParser
{
    /**
     * @param $data
     * @param BaseItemCommandInterface $command
     * @throws InvalidAnswerIdException
     */
    public function parse($data, BaseItemCommandInterface $command): void
    {
        $defaultAnswerId = false;

        if (!array_key_exists('answers', $data) || !is_array($data['answers'])) {
            throw new InvalidArgumentException('answers is required field');
        }

        if (isset($data['defaultAnswer'])) {
            $defaultAnswerData = $data['defaultAnswer'];
            if (!array_key_exists('answerId', $defaultAnswerData)) {
                throw new InvalidArgumentException('answerId is required field in object defaultAnswer');
            }
            $defaultAnswerId = $defaultAnswerData['answerId'];
        }

        $answersData = $data['answers'];

        foreach ($answersData as $key => $answerData) {
            $answerModel = $this->parseAnswer($command->getId(), $answerData, ++$key);

            if ($defaultAnswerId && $answerData['answerId'] === $defaultAnswerId) {
                $command->setdefaultAnswer($answerModel);
            }

            $answers[] = $answerModel;
        }

        if (!isset($answers) || !count($answers)) {
            throw new InvalidArgumentException('answers can not be empty');
        }

        $command->setAnswers(new Set($answers));
    }
}
