<?php

namespace App\App\Doctrine\Mapper\Service;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\DeviceRepository as DeviceEntityRepository;
use App\App\Doctrine\Repository\FacilityRepository as FacilityEntityRepository;
use App\App\Doctrine\Repository\ServiceRepository as ServiceEntityRepository;
use App\App\Doctrine\Repository\UserRepository as UserEntityRepository;
use App\App\Mapper\Exception\EntityNotFound;
use App\Core\Model\Service\ServiceInterface;

class ServiceModel implements ServiceModelInterface
{
    /** @var ServiceEntityRepository */
    private $serviceEntityRepository;

    /** @var DeviceEntityRepository */
    private $deviceEntityRepository;

    /** @var FacilityEntityRepository */
    private $facilityEntityRepository;

    /** @var UserEntityRepository */
    private $userEntityRepository;

    /**
     * ServiceModel constructor.
     * @param ServiceEntityRepository $serviceEntityRepository
     * @param DeviceEntityRepository $deviceEntityRepository
     * @param FacilityEntityRepository $facilityEntityRepository
     * @param UserEntityRepository $userEntityRepository
     */
    public function __construct(
        ServiceEntityRepository $serviceEntityRepository,
        DeviceEntityRepository $deviceEntityRepository,
        FacilityEntityRepository $facilityEntityRepository,
        UserEntityRepository $userEntityRepository
    ) {
        $this->serviceEntityRepository = $serviceEntityRepository;
        $this->deviceEntityRepository = $deviceEntityRepository;
        $this->facilityEntityRepository = $facilityEntityRepository;
        $this->userEntityRepository = $userEntityRepository;
    }

    /**
     * @param ServiceInterface $service
     * @return ServiceEntity
     * @throws EntityNotFound
     */
    public function map(ServiceInterface $service): ServiceEntity
    {
        /** @var ServiceEntity $serviceEntity */
        $serviceEntity = $this->serviceEntityRepository->find($service->getId()->getValue());

        if (!$serviceEntity instanceof ServiceEntity) {
            throw new EntityNotFound("Service entity was not found");
        }
        $this->mapGeneralInfo($service, $serviceEntity);

        return $serviceEntity;
    }

    /**
     * @param ServiceInterface $service
     * @return ServiceEntity
     */
    public function mapNew(ServiceInterface $service): ServiceEntity
    {
        $serviceEntity = new ServiceEntity();
        $serviceEntity->setId($service->getId()->getValue());
        $this->mapCreatedInfo($service, $serviceEntity);
        $this->mapGeneralInfo($service, $serviceEntity);

        return $serviceEntity;
    }

    /**
     * @param ServiceInterface $service
     * @param ServiceEntity $serviceEntity
     */
    private function mapCreatedInfo(ServiceInterface $service, ServiceEntity $serviceEntity)
    {
        $serviceEntity->setCreatedAt($service->getCreatedAt());
        /** @var UserEntity $createdByEntity */
        $createdByEntity = $this->userEntityRepository->find($service->getCreatedBy()->getId());
        $serviceEntity->setCreatedBy($createdByEntity);
    }

    /**
     * @param ServiceInterface $service
     * @param ServiceEntity $serviceEntity
     */
    private function mapGeneralInfo(ServiceInterface $service, ServiceEntity $serviceEntity)
    {
        /** @var DeviceEntity $deviceEntity */
        $deviceEntity = $this->deviceEntityRepository->find($service->getDeviceId()->getValue());

        /** @var FacilityEntity $facilityEntity */
        $facilityEntity = $this->facilityEntityRepository->find($service->getFacility()->getId()->getValue());

        $serviceEntity->setName($service->getName());
        $serviceEntity->setDevice($deviceEntity);
        $serviceEntity->setFacility($facilityEntity);
        if ($service->getComment()) {
            $serviceEntity->setComment($service->getComment());
        }
        $serviceEntity->setUpdatedAt($service->getUpdatedAt());

        if ($service->getModifiedBy()) {
            /** @var UserEntity $createdByEntity */
            $modifiedByEntity = $this->userEntityRepository->find($service->getModifiedBy()->getId());
            $serviceEntity->setModifiedBy($modifiedByEntity);
        }
    }
}
