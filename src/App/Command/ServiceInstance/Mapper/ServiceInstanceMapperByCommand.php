<?php

namespace App\App\Command\ServiceInstance\Mapper;

use App\App\Component\Message\MessageInterface;
use App\App\Factory\ServiceInstance\ServiceInstanceFactoryInterface;
use App\Core\Model\Service\Service;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;

class ServiceInstanceMapperByCommand implements ServiceInstanceMapperByCommandInterface
{
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var ServiceInstanceFactoryInterface */
    private $serviceInstanceFactory;

    /**
     * ServiceInstanceMapperByCommand constructor.
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param ServiceInstanceFactoryInterface $serviceInstanceFactory
     */
    public function __construct(
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        ServiceInstanceFactoryInterface $serviceInstanceFactory
    ) {
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->serviceInstanceFactory = $serviceInstanceFactory;
    }

    /**
     * @param MessageInterface $command
     * @return ServiceInstanceInterface
     */
    public function map(MessageInterface $command): ServiceInstanceInterface
    {
        /** @var Service $service */
        $service = $this->serviceQueryRepository->find($command->getServiceId());
        /** @var ServiceInstanceInterface $serviceInstance */
        $serviceInstance = $this->serviceInstanceFactory->make(
            $command->getId(),
            $service,
            $command->getFacilityId()
        );
        $this->mapBaseFields($command, $serviceInstance);

        return $serviceInstance;
    }

    /**
     * @param MessageInterface $command
     * @param ServiceInstanceInterface $serviceInstance
     */
    private function mapBaseFields(MessageInterface $command, ServiceInstanceInterface $serviceInstance): void
    {
        $serviceInstance->setCreatedBy($command->getCreatedBy());
        $serviceInstance->setModifiedBy($command->getModifiedBy());
    }
}
