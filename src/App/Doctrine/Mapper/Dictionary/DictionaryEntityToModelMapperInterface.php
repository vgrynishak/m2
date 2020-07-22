<?php

namespace App\App\Doctrine\Mapper\Dictionary;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryInterface;

interface DictionaryEntityToModelMapperInterface
{
    /**
     * @param DictionaryEntity $deviceEntity
     * @return DictionaryInterface
     * @throws InvalidDictionaryIdException
     */
    public function map(DictionaryEntity $deviceEntity): DictionaryInterface;
}
