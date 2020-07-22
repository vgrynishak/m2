<?php

namespace App\App\Doctrine\Mapper\Dictionary;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\Core\Model\Item\InformationItem\Dictionary\Dictionary;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;
use App\Core\Model\Exception\InvalidDictionaryIdException;

class DictionaryEntityToModelMapper implements DictionaryEntityToModelMapperInterface
{
    /**
     * @param DictionaryEntity $dictionaryEntity
     * @return DictionaryInterface
     * @throws InvalidDictionaryIdException
     */
    public function map(DictionaryEntity $dictionaryEntity): DictionaryInterface
    {
        $dictionary = new Dictionary(new DictionaryId($dictionaryEntity->getId()), $dictionaryEntity->getName());

        $dictionary->setDescription($dictionaryEntity->getDescription());

        return $dictionary;
    }
}
