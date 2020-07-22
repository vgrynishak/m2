<?php

namespace App\App\Doctrine\Mapper\ServiceInstance;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Doctrine\Repository\FacilityRepository;
use App\App\Doctrine\Repository\ServiceInstanceRepository;
use App\App\Doctrine\Repository\ServiceRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;

class ServiceInstanceModel implements ServiceInstanceModelInterface
{
    /** @var UserRepository */
    private $userRepository;
    /** @var ServiceRepository */
    private $serviceRepository;
    /** @var FacilityRepository */
    private $facilityRepository;
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;

    /**
     * ServiceInstanceModel constructor.
     * @param UserRepository $userRepository
     * @param ServiceRepository $serviceRepository
     * @param FacilityRepository $facilityRepository
     * @param ServiceInstanceRepository $serviceInstanceRepository
     */
    public function __construct(
        UserRepository $userRepository,
        ServiceRepository $serviceRepository,
        FacilityRepository $facilityRepository,
        ServiceInstanceRepository $serviceInstanceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->serviceRepository = $serviceRepository;
        $this->facilityRepository = $facilityRepository;
        $this->serviceInstanceRepository = $serviceInstanceRepository;
    }

    /**
     * @param ServiceInstanceInterface $serviceInstance
     * @return ServiceInstanceEntity
     */
    public function mapNew(ServiceInstanceInterface $serviceInstance): ServiceInstanceEntity
    {
        $serviceInstanceEntity = new ServiceInstanceEntity();
        $serviceInstanceEntity->setId($serviceInstance->getId()->getValue());
        $this->mapCreatedInfo($serviceInstance, $serviceInstanceEntity);
        $this->mapGeneralInfo($serviceInstance, $serviceInstanceEntity);

        return $serviceInstanceEntity;
    }

    /**
     * @param ServiceInstanceInterface $serviceInstance
     * @param ServiceInstanceEntity $serviceInstanceEntity
     */
    private function mapCreatedInfo(
        ServiceInstanceInterface $serviceInstance,
        ServiceInstanceEntity $serviceInstanceEntity
    ): void {
        /** @var UserEntity $createdByEntity */
        $createdByEntity = $this->userRepository->find($serviceInstance->getCreatedBy()->getId());
        $serviceInstanceEntity->setCreatedBy($createdByEntity);
        $serviceInstanceEntity->setCreatedAt($serviceInstance->getCreatedAt());
    }

    /**
     * @param ServiceInstanceInterface $serviceInstance
     * @param ServiceInstanceEntity $serviceInstanceEntity
     */
    private function mapGeneralInfo(
        ServiceInstanceInterface $serviceInstance,
        ServiceInstanceEntity $serviceInstanceEntity
    ): void {
        /** @var UserEntity $modifiedBy */
        $modifiedByEntity = $this->userRepository->find($serviceInstance->getModifiedBy()->getId());
        /** @var FacilityEntity $facilityEntity */
        $facilityEntity = $this->facilityRepository->find($serviceInstance->getFacilityId()->getValue());
        /** @var ServiceEntity $serviceEntity */
        $serviceEntity = $this->serviceRepository->find($serviceInstance->getService()->getId()->getValue());

        $serviceInstanceEntity->setService($serviceEntity);
        $serviceInstanceEntity->setFacility($facilityEntity);
        $serviceInstanceEntity->setModifiedBy($modifiedByEntity);
        $serviceInstanceEntity->setUpdatedAt($serviceInstance->getModifiedAt());
    }
}
