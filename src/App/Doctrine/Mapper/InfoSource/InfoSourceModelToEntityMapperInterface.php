<?php

namespace App\App\Doctrine\Mapper\InfoSource;

use App\App\Doctrine\Entity\Item\Dictionary as DictionaryEntity;
use App\App\Doctrine\Entity\Item\InfoSource as InfoSourceEntity;
use App\Core\Model\DeviceDynamicField\DeviceDynamicField;

interface InfoSourceModelToEntityMapperInterface
{
    /**
     * @param DeviceDynamicField $deviceDynamicField
     * @param DictionaryEntity $dictionary
     * @return InfoSourceEntity
     */
    public function mapByDynamicFieldAndDictionary(
        DeviceDynamicField $deviceDynamicField,
        DictionaryEntity $dictionary
    ): InfoSourceEntity;
}
