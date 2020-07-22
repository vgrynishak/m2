<?php

namespace App\App\Mapper\DeviceDynamicField;

use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;

interface DoctrineEntityDeviceDynamicFieldMapperInterface
{
    /**
     * @param DeviceDynamicFieldEntity $dynamicFieldEntity
     * @return DeviceDynamicFieldInterface
     */
    public function map(DeviceDynamicFieldEntity $dynamicFieldEntity): DeviceDynamicFieldInterface;
}
