<?php

namespace App\App\Repository\ServiceInstance;

use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Repository\ServiceInstanceRepository;
use App\App\Mapper\ServiceInstance\DoctrineEntityServiceInstanceMapperInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\ServiceInstance\ServiceInstanceQueryRepositoryInterface;

class ServiceInstanceQueryRepository implements ServiceInstanceQueryRepositoryInterface
{
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;
    /** @var DoctrineEntityServiceInstanceMapperInterface */
    private $doctrineEntityServiceInstanceMapper;

    /**
     * ServiceInstanceQueryRepository constructor.
     * @param ServiceInstanceRepository $serviceInstanceRepository
     * @param DoctrineEntityServiceInstanceMapperInterface $doctrineEntityServiceInstanceMapper
     */
    public function __construct(
        ServiceInstanceRepository $serviceInstanceRepository,
        DoctrineEntityServiceInstanceMapperInterface $doctrineEntityServiceInstanceMapper
    ) {
        $this->serviceInstanceRepository = $serviceInstanceRepository;
        $this->doctrineEntityServiceInstanceMapper = $doctrineEntityServiceInstanceMapper;
    }

    /**
     * @param ServiceInstanceId $id
     * @return ServiceInstanceInterface|null
     */
    public function find(ServiceInstanceId $id): ?ServiceInstanceInterface
    {
        /** @var ServiceInstanceEntity | null $serviceInstanceEntity */
        $serviceInstanceEntity = $this->serviceInstanceRepository->find($id->getValue());

        if (!$serviceInstanceEntity instanceof ServiceInstanceEntity) {
            return null;
        }

        return $this->doctrineEntityServiceInstanceMapper->map($serviceInstanceEntity);
    }
}
