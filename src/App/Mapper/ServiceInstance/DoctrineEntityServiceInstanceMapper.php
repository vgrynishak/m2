<?php

namespace App\App\Mapper\ServiceInstance;

use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Factory\DeviceInstance\DeviceInstanceFactoryInterface;
use App\App\Factory\ServiceInstance\ServiceInstanceFactoryInterface;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstance;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;

class DoctrineEntityServiceInstanceMapper implements DoctrineEntityServiceInstanceMapperInterface
{
    /** @var ServiceInstanceFactoryInterface */
    private $serviceInstanceFactory;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var DoctrineEntityUserMapperInterface */
    private $doctrineEntityUserMapper;

    /**
     * DoctrineEntityServiceInstanceMapper constructor.
     * @param ServiceInstanceFactoryInterface $serviceInstanceFactory
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
     */
    public function __construct(
        ServiceInstanceFactoryInterface $serviceInstanceFactory,
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
    ) {
        $this->serviceInstanceFactory = $serviceInstanceFactory;
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->doctrineEntityUserMapper = $doctrineEntityUserMapper;
    }

    /**
     * @param ServiceInstanceEntity $serviceInstanceEntity
     * @return ServiceInstanceInterface
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     */
    public function map(ServiceInstanceEntity $serviceInstanceEntity): ServiceInstanceInterface
    {
        /** @var ServiceInterface $service */
        $service = $this->serviceQueryRepository->find(new ServiceId($serviceInstanceEntity->getService()->getId()));
        /** @var ServiceInstanceInterface $serviceInstance */
        $serviceInstance = $this->serviceInstanceFactory->make(
            new ServiceInstanceId($serviceInstanceEntity->getId()),
            $service,
            new FacilityId($serviceInstanceEntity->getFacility()->getId())
        );

        /** @var UserEntity $modifiedBy */
        $modifiedBy = $serviceInstanceEntity->getModifiedBy();
        if ($modifiedBy instanceof UserEntity) {
            $serviceInstance->setModifiedBy($this->doctrineEntityUserMapper->map($modifiedBy));
        }
        /** @var UserEntity $createdBy */
        $createdBy = $serviceInstanceEntity->getCreatedBy();
        if ($createdBy instanceof UserEntity) {
            $serviceInstance->setCreatedBy($this->doctrineEntityUserMapper->map($createdBy));
        }

        $serviceInstance->setModifiedAt($serviceInstanceEntity->getUpdatedAt());
        $serviceInstance->setCreatedAt($serviceInstanceEntity->getCreatedAt());

        return $serviceInstance;
    }
}
