<?php

namespace App\Core\Repository\InfoSource;

use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Exception\InvalidInfoSourceIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use PhpCollection\CollectionInterface;

interface InfoSourceQueryRepositoryInterface
{
    /**
     * @param InfoSourceId $id
     * @return InfoSourceInterface|null
     * @throws InvalidDictionaryIdException
     * @throws InvalidInfoSourceIdException
     */
    public function find(InfoSourceId $id): ?InfoSourceInterface;

    /**
     * @param DictionaryId $dictionaryId
     * @return CollectionInterface|null
     * @throws InvalidDictionaryIdException
     * @throws InvalidInfoSourceIdException
     */
    public function findAllByDictionaryId(DictionaryId $dictionaryId): ?CollectionInterface;
}
