<?php

namespace App\App\Doctrine\Mapper\DeviceInstance;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\DeviceInstanceRepository;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Doctrine\Repository\FacilityRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;

class DeviceInstanceModel implements DeviceInstanceModelInterface
{
    /** @var UserRepository */
    private $userRepository;
    /** @var DeviceRepository */
    private $deviceRepository;
    /** @var FacilityRepository */
    private $facilityRepository;
    /** @var DeviceInstanceRepository */
    private $deviceInstanceRepository;

    /**
     * DeviceInstanceModel constructor.
     * @param UserRepository $userRepository
     * @param DeviceRepository $deviceRepository
     * @param FacilityRepository $facilityRepository
     * @param DeviceInstanceRepository $deviceInstanceRepository
     */
    public function __construct(
        UserRepository $userRepository,
        DeviceRepository $deviceRepository,
        FacilityRepository $facilityRepository,
        DeviceInstanceRepository $deviceInstanceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->deviceRepository = $deviceRepository;
        $this->facilityRepository = $facilityRepository;
        $this->deviceInstanceRepository = $deviceInstanceRepository;
    }

    /**
     * @param DeviceInstanceInterface $deviceInstance
     * @return DeviceInstanceEntity
     */
    public function mapNew(DeviceInstanceInterface $deviceInstance): DeviceInstanceEntity
    {
        $deviceInstanceEntity = new DeviceInstanceEntity();
        $deviceInstanceEntity->setId($deviceInstance->getId()->getValue());
        $this->mapCreatedInfo($deviceInstance, $deviceInstanceEntity);
        $this->mapGeneralInfo($deviceInstance, $deviceInstanceEntity);

        return $deviceInstanceEntity;
    }

    /**
     * @param DeviceInstanceInterface $deviceInstance
     * @param DeviceInstanceEntity $deviceInstanceEntity
     */
    private function mapCreatedInfo(
        DeviceInstanceInterface $deviceInstance,
        DeviceInstanceEntity $deviceInstanceEntity
    ): void {
        /** @var UserEntity $createdByEntity */
        $createdByEntity = $this->userRepository->find($deviceInstance->getCreatedBy()->getId());
        $deviceInstanceEntity->setCreatedBy($createdByEntity);
        $deviceInstanceEntity->setCreatedAt($deviceInstance->getCreatedAt());
    }

    /**
     * @param DeviceInstanceInterface $deviceInstance
     * @param DeviceInstanceEntity $deviceInstanceEntity
     */
    private function mapGeneralInfo(
        DeviceInstanceInterface $deviceInstance,
        DeviceInstanceEntity $deviceInstanceEntity
    ): void {
        /** @var UserEntity $modifiedByEntity */
        $modifiedByEntity = $this->userRepository->find($deviceInstance->getModifiedBy()->getId());
        /** @var FacilityEntity $facilityEntity */
        $facilityEntity = $this->facilityRepository->find($deviceInstance->getFacilityId()->getValue());
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = $this->deviceRepository->find($deviceInstance->getDevice()->getId()->getValue());
        if ($deviceInstance->getParentId() instanceof DeviceInstanceId) {
            /** @var DeviceInstanceEntity $parentEntity */
            $parentEntity = $this->deviceInstanceRepository->find($deviceInstance->getParentId()->getValue());
            $deviceInstanceEntity->setParent($parentEntity);
        }
        $deviceInstanceEntity->setDevice($deviceEntity);
        $deviceInstanceEntity->setFacility($facilityEntity);
        $deviceInstanceEntity->setModifiedBy($modifiedByEntity);
        $deviceInstanceEntity->setUpdatedAt($deviceInstance->getModifiedAt());
    }
}
