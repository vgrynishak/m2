<?php

namespace App\Infrastructure\Parser\Item\InputItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\App\Command\Item\InputItem\InputItemCommandInterface;
use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\Infrastructure\Parser\Item\BaseItemParser;
use App\Infrastructure\Parser\Item\DefaultAnswerParser;
use App\Infrastructure\Parser\Item\LabelParser;
use App\Core\Model\Exception\InvalidAnswerIdException;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;

abstract class BaseInputItemParser
{
    /** @var DefaultAnswerParser */
    private $defaultAnswerParser;
    /** @var BaseItemParser */
    private $baseItemParser;
    /** @var LabelParser */
    private $labelParser;

    /**
     * CreateInputItemParser constructor.
     * @param DefaultAnswerParser $defaultAnswerParser
     * @param BaseItemParser $baseItemParser
     * @param LabelParser $labelParser
     */
    public function __construct(
        DefaultAnswerParser $defaultAnswerParser,
        BaseItemParser $baseItemParser,
        LabelParser $labelParser
    ) {
        $this->defaultAnswerParser = $defaultAnswerParser;
        $this->baseItemParser = $baseItemParser;
        $this->labelParser = $labelParser;
    }

    /**
     * @param $data
     * @param InputItemCommandInterface $command
     * @return CreateInputItemCommandInterface | UpdateInputItemCommandInterface
     * @throws InvalidAnswerIdException
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parseRequestAndFillCommand($data, InputItemCommandInterface $command) : InputItemCommandInterface
    {
        /** @var BaseItemCommandInterface | InputItemCommandInterface $command */
        $this->baseItemParser->parse($data, $command);
        $this->labelParser->parse($data, $command);
        $this->defaultAnswerParser->parse($data, $command);

        $command->setPlaceholder($data['placeholder'] ?? null);
        $command->setNFPAref($data['NFPAref'] ?? null);
        $command->setRemembered($data['remembered'] ?? null);
        $command->setRequired($data['required'] ?? null);

        return $command;
    }
}
