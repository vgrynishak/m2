<?php

namespace App\Core\Repository\Dictionary;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;

interface DictionaryQueryRepositoryInterface
{
    /**
     * @param DictionaryId $dictionaryId
     * @return DictionaryInterface|null
     * @throws InvalidDictionaryIdException
     */
    public function find(DictionaryId $dictionaryId): ?DictionaryInterface;
}
