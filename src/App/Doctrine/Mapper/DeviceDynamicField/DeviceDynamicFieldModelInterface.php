<?php

namespace App\App\Doctrine\Mapper\DeviceDynamicField;

use PhpCollection\CollectionInterface;
use App\App\Doctrine\Entity\Device as DeviceEntity;

interface DeviceDynamicFieldModelInterface
{
    /**
     * @param CollectionInterface $deviceDynamicFields
     * @param DeviceEntity $deviceEntity
     * @return CollectionInterface
     */
    public function mapNewByDevice(
        CollectionInterface $deviceDynamicFields,
        DeviceEntity $deviceEntity
    ): CollectionInterface;
}
