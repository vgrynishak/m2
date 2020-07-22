<?php


namespace App\Infrastructure\Parser\Item\PictureItem;

use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\App\Command\Item\PictureItem\PictureItemCommandInterface;
use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Parser\Item\BaseItemParser;
use App\Infrastructure\Parser\Item\LabelParser;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;

abstract class BasePictureItemParser
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
     * @param PictureItemCommandInterface $command
     * @return CreatePictureItemCommandInterface | UpdatePictureItemCommandInterface
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parseRequestAndFillCommand($data, PictureItemCommandInterface $command): PictureItemCommandInterface
    {

        $this->baseItemParser->parse($data, $command);
        $this->labelParser->parse($data, $command);

        $command->setNFPAref($data['NFPAref'] ?? null);
        $command->setRemembered($data['remembered'] ?? null);
        $command->setRequired($data['required'] ?? null);

        return $command;
    }
}