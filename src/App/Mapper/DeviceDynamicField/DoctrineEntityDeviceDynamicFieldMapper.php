<?php

namespace App\App\Mapper\DeviceDynamicField;

use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceDynamicField\DeviceDynamicField;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldId;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use App\Core\Model\Exception\InvalidDeviceDynamicFieldIdException;
use App\Core\Model\Exception\InvalidDeviceIdException;

class DoctrineEntityDeviceDynamicFieldMapper implements DoctrineEntityDeviceDynamicFieldMapperInterface
{
    /**
     * @param DeviceDynamicFieldEntity $dynamicFieldEntity
     * @return DeviceDynamicFieldInterface
     * @throws InvalidDeviceDynamicFieldIdException
     * @throws InvalidDeviceIdException
     */
    public function map(DeviceDynamicFieldEntity $dynamicFieldEntity): DeviceDynamicFieldInterface
    {
        /** @var DeviceDynamicFieldInterface $deviceDynamicField */
        $deviceDynamicField = new DeviceDynamicField(
            new DeviceDynamicFieldId($dynamicFieldEntity->getId()),
            new DeviceId($dynamicFieldEntity->getDevice()->getId()),
            $dynamicFieldEntity->getName()
        );

        return $deviceDynamicField;
    }
}
