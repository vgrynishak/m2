<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Command\Item\BaseItemCommandInterface;
use App\Core\Model\Exception\InvalidAnswerIdException;

class DefaultAnswerParser extends BaseAnswerParser
{
    /**
     * @param $data
     * @param BaseItemCommandInterface $command
     * @throws InvalidAnswerIdException
     */
    public function parse($data, BaseItemCommandInterface $command)
    {
        if (isset($data['defaultAnswer']) && $data['defaultAnswer']) {
            $defaultAnswerData = $data['defaultAnswer'];
            $defaultAnswer = $this->parseAnswer($command->getId(), $defaultAnswerData, 1);
            $command->setDefaultAnswer($defaultAnswer ?? null);
        }
    }
}
