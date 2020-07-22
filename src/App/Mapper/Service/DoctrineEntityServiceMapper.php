<?php

namespace App\App\Mapper\Service;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Factory\Service\ServiceFactoryInterface;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use DateTime;

class DoctrineEntityServiceMapper implements DoctrineEntityServiceMapperInterface
{
    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /** @var DoctrineEntityUserMapperInterface */
    private $doctrineEntityUserMapper;

    /** @var ServiceFactoryInterface */
    private $serviceFactory;

    /**
     * DoctrineEntityServiceMapper constructor.
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param DoctrineEntityUserMapperInterface $doctrineEntityUserMapper
     * @param ServiceFactoryInterface $serviceFactory
     */
    public function __construct(
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        DoctrineEntityUserMapperInterface $doctrineEntityUserMapper,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->doctrineEntityUserMapper = $doctrineEntityUserMapper;
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * @param ServiceEntity $serviceEntity
     * @return ServiceInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     */
    public function map(ServiceEntity $serviceEntity): ServiceInterface
    {
        /** @var FacilityId $facilityId */
        $facilityId = new FacilityId($serviceEntity->getFacility()->getId());
        /** @var FacilityInterface $facility */
        $facility = $this->facilityQueryRepository->find($facilityId);

        /** @var ServiceInterface $service */
        $service = $this->serviceFactory->make(
            new ServiceId($serviceEntity->getId()),
            new DeviceId($serviceEntity->getDevice()->getId()),
            $facility,
            $serviceEntity->getName()
        );

        if ($serviceEntity->getComment()) {
            $service->setComment($serviceEntity->getComment());
        }

        $service->setCreatedAt($serviceEntity->getCreatedAt());
        if ($serviceEntity->getUpdatedAt() instanceof DateTime) {
            $service->setUpdatedAt($serviceEntity->getUpdatedAt());
        }
        $service->setCreatedBy($this->doctrineEntityUserMapper->map($serviceEntity->getCreatedBy()));

        /** @var UserEntity $modifiedBy */
        $modifiedBy = $serviceEntity->getModifiedBy();
        if ($modifiedBy instanceof UserEntity) {
            $service->setModifiedBy($this->doctrineEntityUserMapper->map($modifiedBy));
        }

        return $service;
    }
}
