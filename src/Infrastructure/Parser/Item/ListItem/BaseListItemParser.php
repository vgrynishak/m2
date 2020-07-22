<?php

namespace App\Infrastructure\Parser\Item\ListItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Command\Item\ListItem\ListItemCommandInterface;
use App\App\Command\Item\ListItem\UpdateListItemCommandInterface;
use App\Infrastructure\Parser\Item\BaseItemParser;
use App\Infrastructure\Parser\Item\LabelParser;
use App\Infrastructure\Parser\Item\ListAnswerParser;
use App\Core\Model\Exception\InvalidAnswerIdException;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;

abstract class BaseListItemParser
{
    /** @var ListAnswerParser */
    private $listAnswerParser;
    /** @var BaseItemParser */
    private $baseItemParser;
    /** @var LabelParser */
    private $labelParser;

    /**
     * CreateListItemParser constructor.
     * @param ListAnswerParser $listAnswerParser
     * @param BaseItemParser $baseItemParser
     * @param LabelParser $labelParser
     */
    public function __construct(
        ListAnswerParser $listAnswerParser,
        BaseItemParser $baseItemParser,
        LabelParser $labelParser
    ) {
        $this->listAnswerParser = $listAnswerParser;
        $this->baseItemParser = $baseItemParser;
        $this->labelParser = $labelParser;
    }

    /**
     * @param $data
     * @param ListItemCommandInterface | BaseItemCommandInterface $command
     * @return CreateListItemCommandInterface | UpdateListItemCommandInterface
     * @throws InvalidAnswerIdException
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parseRequestAndFillCommand($data, ListItemCommandInterface $command): ListItemCommandInterface
    {
        $this->baseItemParser->parse($data, $command);
        $this->labelParser->parse($data, $command);
        $this->listAnswerParser->parse($data, $command);

        $command->setPlaceholder($data['placeholder'] ?? null);
        $command->setNFPAref($data['NFPAref'] ?? null);
        $command->setRemembered($data['remembered'] ?? null);
        $command->setRequired($data['required'] ?? null);

        return $command;
    }
}
