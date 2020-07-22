<?php

namespace App\App\Mapper\Device;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Mapper\DeviceDynamicField\DoctrineEntityDeviceDynamicFieldMapperInterface;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use PhpCollection\Set;

class DoctrineEntityDeviceMapper implements DoctrineEntityDeviceMapperInterface
{
    /** @var DoctrineEntityUserMapperInterface */
    private $doctrineEntityUserMapper;
    /** @var DoctrineEntityDeviceDynamicFieldMapperInterface */
    private $doctrineEntityDeviceDynamicFieldMapper;

    /**
     * DoctrineEntityDeviceMapper constructor.
     * @param DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
     * @param DoctrineEntityDeviceDynamicFieldMapperInterface $doctrineEntityDeviceDynamicFieldMapper
     */
    public function __construct(
        DoctrineEntityUserMapperInterface $doctrineEntityUserMapper,
        DoctrineEntityDeviceDynamicFieldMapperInterface $doctrineEntityDeviceDynamicFieldMapper
    ) {
        $this->doctrineEntityUserMapper = $doctrineEntityUserMapper;
        $this->doctrineEntityDeviceDynamicFieldMapper = $doctrineEntityDeviceDynamicFieldMapper;
    }

    /**
     * @param DeviceEntity $deviceEntity
     * @return DeviceInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidDivisionIdException
     */
    public function map(DeviceEntity $deviceEntity): DeviceInterface
    {
        /** @var DeviceInterface $device */
        $device = new Device(
            new DeviceId($deviceEntity->getId()),
            $deviceEntity->getName(),
            $deviceEntity->getLevel(),
            new DivisionId($deviceEntity->getDivision()->getId()),
            $deviceEntity->getAlias()
        );

        $device->setUpdatedAt($deviceEntity->getUpdatedAt());
        $device->setCreatedAt($deviceEntity->getCreatedAt());
        $device->setDescription($deviceEntity->getDescription());

        if ($deviceEntity->getParent() instanceof DeviceEntity) {
            $device->setParentId(new DeviceId($deviceEntity->getParent()->getId()));
        }

        /** @var UserEntity $createdBy */
        $createdBy = $deviceEntity->getCreatedBy();
        if ($createdBy instanceof UserEntity) {
            $device->setCreatedBy($this->doctrineEntityUserMapper->map($createdBy));
        }

        /** @var UserEntity $modifiedBy */
        $modifiedBy = $deviceEntity->getModifiedBy();
        if ($modifiedBy instanceof UserEntity) {
            $device->setModifiedBy($this->doctrineEntityUserMapper->map($modifiedBy));
        }

        return $device;
    }
}
