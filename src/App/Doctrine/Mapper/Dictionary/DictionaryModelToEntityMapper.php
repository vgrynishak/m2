<?php

namespace App\App\Doctrine\Mapper\Dictionary;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;

class DictionaryModelToEntityMapper implements DictionaryModelToEntityMapperInterface
{
    /**
     * @param DictionaryInterface $dictionary
     * @return DictionaryEntity
     */
    public function mapNew(DictionaryInterface $dictionary): DictionaryEntity
    {
        return (new DictionaryEntity())
            ->setId($dictionary->getId()->getValue())
            ->setName($dictionary->getName())
            ->setDescription($dictionary->getDescription())
            ;
    }
}
