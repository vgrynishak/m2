<?php

namespace App\App\Doctrine\Mapper\DeviceDynamicField;

use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Repository\DeviceRepository;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class DeviceDynamicFieldModel implements DeviceDynamicFieldModelInterface
{
    /** @var DeviceRepository */
    private $deviceRepository;

    /**
     * DeviceDynamicFieldModel constructor.
     * @param DeviceRepository $deviceRepository
     */
    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @param CollectionInterface $deviceDynamicFields
     * @param DeviceEntity $deviceEntity
     * @return CollectionInterface
     */
    public function mapNewByDevice(
        CollectionInterface $deviceDynamicFields,
        DeviceEntity $deviceEntity
    ): CollectionInterface {
        /** @var DeviceDynamicFieldEntity[] $deviceDynamicFieldEntities */
        $deviceDynamicFieldEntities = [];
        /** @var DeviceDynamicFieldInterface $dynamicField */
        foreach ($deviceDynamicFields as $dynamicField) {
            /** @var DeviceDynamicFieldEntity $deviceDynamicFieldEntity */
            $deviceDynamicFieldEntity = new DeviceDynamicFieldEntity();
            $deviceDynamicFieldEntity->setId($dynamicField->getId()->getValue());
            $deviceDynamicFieldEntity->setDevice($deviceEntity);
            $deviceDynamicFieldEntity->setName($dynamicField->getName());

            $deviceDynamicFieldEntities[] = $deviceDynamicFieldEntity;
        }

        return new Set($deviceDynamicFieldEntities);
    }
}
