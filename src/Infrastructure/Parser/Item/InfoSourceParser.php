<?php

namespace App\Infrastructure\Parser\Item;

use App\App\Command\Item\Base\InfoSourceInterface;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;
use App\Core\Model\Exception\InvalidInfoSourceIdException;

class InfoSourceParser
{
    /**
     * @param $data
     * @param InfoSourceInterface $command
     * @throws InvalidInfoSourceIdException
     */
    public function parse($data, InfoSourceInterface $command): void
    {
        if (!array_key_exists('infoSource', $data)) {
            throw new \InvalidArgumentException('infoSource is required field');
        }

        $infoSourceData = $data['infoSource'];

        if (!array_key_exists('infoSourceId', $infoSourceData)) {
            throw new \InvalidArgumentException('infoSourceId is required field in object infoSource');
        }

        $command->setInfoSourceId(new InfoSourceId($infoSourceData['infoSourceId']));
    }
}
