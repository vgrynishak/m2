<?php

namespace App\Infrastructure\Parser\Item\PickerItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\App\Command\Item\PickerItem\PickerItemCommandInterface;
use App\App\Command\Item\PickerItem\UpdatePickerItemCommandInterface;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Parser\Item\BaseItemParser;
use App\Infrastructure\Parser\Item\LabelParser;

abstract class BasePickerItemParser
{
    /** @var BaseItemParser */
    private $baseItemParser;
    /** @var LabelParser */
    private $labelParser;

    /**
     * CreateInputItemParser constructor.
     * @param BaseItemParser $baseItemParser
     * @param LabelParser $labelParser
     */
    public function __construct(
        BaseItemParser $baseItemParser,
        LabelParser $labelParser
    ) {
        $this->baseItemParser = $baseItemParser;
        $this->labelParser = $labelParser;
    }

    /**
     * @param $data
     * @param PickerItemCommandInterface | BaseItemCommandInterface $command
     * @return CreatePickerItemCommandInterface | UpdatePickerItemCommandInterface
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parseRequestAndFillCommand($data, PickerItemCommandInterface $command): PickerItemCommandInterface
    {
        $this->baseItemParser->parse($data, $command);
        $this->labelParser->parse($data, $command);

        $command->setNFPAref($data['NFPAref'] ?? null);
        $command->setRemembered($data['remembered'] ?? null);
        $command->setRequired($data['required'] ?? null);
        $command->setPlaceholder($data['placeholder'] ?? null);

        return $command;
    }
}
