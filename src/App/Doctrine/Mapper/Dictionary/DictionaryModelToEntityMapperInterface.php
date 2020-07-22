<?php

namespace App\App\Doctrine\Mapper\Dictionary;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;

interface DictionaryModelToEntityMapperInterface
{
    /**
     * @param DictionaryInterface $dictionary
     * @return DictionaryEntity
     */
    public function mapNew(DictionaryInterface $dictionary): DictionaryEntity;
}
