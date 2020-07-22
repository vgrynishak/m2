<?php

namespace App\App\Doctrine\Mapper\InfoSource;

use App\App\Doctrine\Entity\Item\InfoSource as InfoSourceEntity;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;
use App\Core\Model\Item\InformationItem\Dictionary\DictionaryId;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSource;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;

class InfoSourceEntityToModelMapper implements InfoSourceEntityToModelMapperInterface
{
    /**
     * @inheritDoc
     */
    public function map(InfoSourceEntity $infoSourceEntity): InfoSourceInterface
    {
        return new InfoSource(
            new InfoSourceId($infoSourceEntity->getId()),
            new DictionaryId($infoSourceEntity->getDictionary()->getId()),
            $infoSourceEntity->getName()
        );
    }
}
