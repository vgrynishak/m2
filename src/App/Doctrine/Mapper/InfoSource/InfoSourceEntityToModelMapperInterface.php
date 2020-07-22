<?php

namespace App\App\Doctrine\Mapper\InfoSource;

use App\App\Doctrine\Entity\Item\InfoSource as InfoSourceEntity;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use App\Core\Model\Exception\InvalidInfoSourceIdException;
use App\Core\Model\Exception\InvalidDictionaryIdException;

interface InfoSourceEntityToModelMapperInterface
{
    /**
     * @param InfoSourceEntity $infoSourceEntity
     * @return InfoSourceInterface
     * @throws InvalidInfoSourceIdException
     * @throws InvalidDictionaryIdException
     */
    public function map(InfoSourceEntity $infoSourceEntity): InfoSourceInterface;
}
