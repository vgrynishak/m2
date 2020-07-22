<?php

namespace App\App\Mapper\DeviceInstance;

use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Factory\DeviceInstance\DeviceInstanceFactoryInterface;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstance;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;

class DoctrineEntityDeviceInstanceMapper implements DoctrineEntityDeviceInstanceMapperInterface
{
    /** @var DeviceInstanceFactoryInterface */
    private $deviceInstanceFactory;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DoctrineEntityUserMapperInterface */
    private $doctrineEntityUserMapper;

    /**
     * DoctrineEntityDeviceInstanceMapper constructor.
     * @param DeviceInstanceFactoryInterface $deviceInstanceFactory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
     */
    public function __construct(
        DeviceInstanceFactoryInterface $deviceInstanceFactory,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
    ) {
        $this->deviceInstanceFactory = $deviceInstanceFactory;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->doctrineEntityUserMapper = $doctrineEntityUserMapper;
    }

    /**
     * @param DeviceInstanceEntity $deviceInstanceEntity
     * @return DeviceInstanceInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidFacilityIdException
     */
    public function map(DeviceInstanceEntity $deviceInstanceEntity): DeviceInstanceInterface
    {
        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find(new DeviceId($deviceInstanceEntity->getDevice()->getId()));
        /** @var DeviceInstanceInterface $deviceInstance */
        $deviceInstance = $this->deviceInstanceFactory->make(
            new DeviceInstanceId($deviceInstanceEntity->getId()),
            $device,
            new FacilityId($deviceInstanceEntity->getFacility()->getId())
        );
        /** @var UserEntity $createdBy */
        $createdBy = $deviceInstanceEntity->getCreatedBy();
        if ($createdBy instanceof UserEntity) {
            $deviceInstance->setCreatedBy($this->doctrineEntityUserMapper->map($createdBy));
        }

        /** @var UserEntity $modifiedBy */
        $modifiedBy = $deviceInstanceEntity->getModifiedBy();
        if ($modifiedBy instanceof UserEntity) {
            $deviceInstance->setModifiedBy($this->doctrineEntityUserMapper->map($modifiedBy));
        }
        $deviceInstance->setModifiedAt($deviceInstanceEntity->getUpdatedAt());
        $deviceInstance->setCreatedAt($deviceInstanceEntity->getCreatedAt());
        /** @var DeviceInstance | null $parent */
        $parent = $deviceInstanceEntity->getParent();
        if ($parent instanceof DeviceInstanceEntity) {
            $deviceInstance->setParentId(new DeviceInstanceId($parent->getId()));
        }

        return $deviceInstance;
    }
}
