<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Command\Item\BaseItemCommandInterface;
use App\Core\Model\Item\ItemId;
use App\Core\Model\Item\ItemType\ItemTypeId;
use App\Core\Model\Paragraph\ParagraphId;
use InvalidArgumentException;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;

class BaseItemParser
{
    /**
     * @param $data
     * @param BaseItemCommandInterface $command
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     */
    public function parse($data, BaseItemCommandInterface $command): void
    {
        if (!array_key_exists('id', $data)) {
            throw new InvalidArgumentException('itemId is required field');
        }

        if (!array_key_exists('paragraphId', $data)) {
            throw new InvalidArgumentException('paragraphId is required field');
        }

        if (!array_key_exists('itemTypeId', $data)) {
            throw new InvalidArgumentException('itemTypeId is required field');
        }

        $command->setId(new ItemId($data['id']));
        $command->setPrintable($data['printable'] ?? null);
        $command->setItemTypeId(new ItemTypeId($data['itemTypeId']));
        $command->setParagraphId(new ParagraphId($data['paragraphId']));
    }
}
