<?php

namespace App\App\Doctrine\Mapper\Device;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\Division as DivisionEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Exception\NonExistentEntity;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Doctrine\Repository\DivisionRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\Mapper\Exception\EntityNotFound;
use App\Core\Model\Device\DeviceInterface;

class DeviceModel implements DeviceModelInterface
{
    /** @var DeviceRepository */
    private $deviceRepository;
    /** @var DivisionRepository */
    private $divisionRepository;
    /** @var UserRepository */
    private $userRepository;

    /**
     * DeviceModel constructor.
     * @param DeviceRepository $deviceRepository
     * @param DivisionRepository $divisionRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        DeviceRepository $deviceRepository,
        DivisionRepository $divisionRepository,
        UserRepository $userRepository
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->divisionRepository = $divisionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeviceInterface $device
     * @return DeviceEntity
     * @throws EntityNotFound
     * @throws NonExistentEntity
     */
    public function map(DeviceInterface $device): DeviceEntity
    {
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = $this->deviceRepository->find($device->getId()->getValue());
        if (!$deviceEntity instanceof DeviceEntity) {
            throw new EntityNotFound("Device entity not found");
        }

        $this->mapGeneralInfo($device, $deviceEntity);

        return $deviceEntity;
    }

    /**
     * @param DeviceInterface $device
     * @return DeviceEntity
     * @throws NonExistentEntity
     */
    public function mapNew(DeviceInterface $device): DeviceEntity
    {
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = new DeviceEntity();
        $deviceEntity->setId($device->getId()->getValue());

        $this->mapCreatedInfo($device, $deviceEntity);
        $this->mapGeneralInfo($device, $deviceEntity);

        return $deviceEntity;
    }

    /**
     * @param DeviceInterface $device
     * @param DeviceEntity $deviceEntity
     * @throws NonExistentEntity
     */
    private function mapGeneralInfo(DeviceInterface $device, DeviceEntity $deviceEntity): void
    {
        /** @var UserEntity $modifiedByEntity */
        $modifiedByEntity = $this->userRepository->find($device->getModifiedBy()->getId());
        if (!$modifiedByEntity instanceof UserEntity) {
            throw new NonExistentEntity("User Entity not exist");
        }
        $deviceEntity->setModifiedBy($modifiedByEntity);
        $deviceEntity->setUpdatedAt($device->getUpdatedAt());
        $deviceEntity->setDescription($device->getDescription());
        $deviceEntity->setName($device->getName());
        $deviceEntity->setLevel($device->getLevel());
        $deviceEntity->setAlias($device->getAlias());

        /** @var DivisionEntity $divisionEntity */
        $divisionEntity = $this->divisionRepository->find($device->getDivisionId()->getValue());
        $deviceEntity->setDivision($divisionEntity);

        if ($device->getParentId()) {
            /** @var DeviceEntity $parentDevice */
            $parentDevice = $this->deviceRepository->find($device->getParentId()->getValue());
            $deviceEntity->setParent($parentDevice);
        }
    }

    /**
     * @param DeviceInterface $device
     * @param DeviceEntity $deviceEntity
     * @throws NonExistentEntity
     */
    private function mapCreatedInfo(DeviceInterface $device, DeviceEntity $deviceEntity): void
    {
        $deviceEntity->setCreatedAt($device->getCreatedAt());
        /** @var UserEntity $createdByEntity */
        $createdByEntity = $this->userRepository->find($device->getCreatedBy()->getId());
        if (!$createdByEntity instanceof UserEntity) {
            throw new NonExistentEntity("User Entity not exist");
        }
        $deviceEntity->setCreatedBy($createdByEntity);
    }
}
