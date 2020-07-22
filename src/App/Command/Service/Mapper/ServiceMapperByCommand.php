<?php

namespace App\App\Command\Service\Mapper;

use App\App\Component\Message\MessageInterface;
use App\App\Factory\Service\ServiceFactoryInterface;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;

class ServiceMapperByCommand implements ServiceMapperByCommandInterface
{
    /** @var ServiceFactoryInterface */
    private $serviceFactory;

    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /**
     * ServiceMapperByCommand constructor.
     * @param ServiceFactoryInterface $serviceFactory
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     */
    public function __construct(
        ServiceFactoryInterface $serviceFactory,
        FacilityQueryRepositoryInterface $facilityQueryRepository
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->facilityQueryRepository = $facilityQueryRepository;
    }

    /**
     * @param MessageInterface $command
     * @return ServiceInterface
     */
    public function map(MessageInterface $command): ServiceInterface
    {
        /** @var FacilityInterface $facility */
        $facility = $this->facilityQueryRepository->find($command->getFacilityId());

        /** @var ServiceInterface $service */
        $service = $this->serviceFactory->make(
            $command->getId(),
            $command->getDeviceId(),
            $facility,
            $command->getName()
        );

        $service->setCreatedBy($command->getCreatedBy());
        if ($command->getModifiedBy()) {
            $service->setModifiedBy($command->getModifiedBy());
        }

        if ($command->getComment()) {
            $service->setComment($command->getComment());
        }

        return $service;
    }
}
