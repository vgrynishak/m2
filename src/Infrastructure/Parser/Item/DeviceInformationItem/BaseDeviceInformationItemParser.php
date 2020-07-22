<?php

namespace App\Infrastructure\Parser\Item\DeviceInformationItem;

use App\App\Command\Item\BaseItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\DeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\App\Command\Item\InputItem\InputItemCommandInterface;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Parser\Item\BaseItemParser;
use App\Infrastructure\Parser\Item\InfoSourceParser;
use App\Infrastructure\Parser\Item\LabelParser;
use App\Core\Model\Exception\InvalidInfoSourceIdException;

abstract class BaseDeviceInformationItemParser
{
    /** @var InfoSourceParser */
    private $infoSourceParser;
    /** @var BaseItemParser */
    private $baseItemParser;
    /** @var LabelParser */
    private $labelParser;

    /**
     * BaseDeviceInformationItemParser constructor.
     * @param InfoSourceParser $infoSourceParser
     * @param BaseItemParser $baseItemParser
     * @param LabelParser $labelParser
     */
    public function __construct(
        InfoSourceParser $infoSourceParser,
        BaseItemParser $baseItemParser,
        LabelParser $labelParser
    ) {
        $this->infoSourceParser = $infoSourceParser;
        $this->baseItemParser = $baseItemParser;
        $this->labelParser = $labelParser;
    }

    /**
     * @param $data
     * @param DeviceInformationItemCommandInterface | BaseItemCommandInterface $command
     * @return CreateDeviceInformationItemCommandInterface | UpdateDeviceInformationItemCommandInterface
     * @throws InvalidInfoSourceIdException
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parseRequestAndFillCommand($data, DeviceInformationItemCommandInterface $command):
     DeviceInformationItemCommandInterface
    {
        /** @var BaseItemCommandInterface | InputItemCommandInterface $command */
        $this->baseItemParser->parse($data, $command);
        $this->labelParser->parse($data, $command);
        $this->infoSourceParser->parse($data, $command);

        return $command;
    }
}
