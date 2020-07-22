<?php

namespace App\App\Doctrine\Mapper\InfoSource;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\App\Doctrine\Entity\Item\InfoSource as InfoSourceEntity;
use App\Core\Model\DeviceDynamicField\DeviceDynamicField;

class InfoSourceModelToEntityMapper implements InfoSourceModelToEntityMapperInterface
{
    /**
     * @inheritDoc
     */
    public function mapByDynamicFieldAndDictionary(
        DeviceDynamicField $deviceDynamicField,
        DictionaryEntity $dictionary
    ): InfoSourceEntity {
        return (new InfoSourceEntity())
            ->setId($deviceDynamicField->getId()->getValue())
            ->setName($deviceDynamicField->getName())
            ->setDictionary($dictionary)
            ;
    }
}
