<?php

namespace App\App\Repository\ServiceInstance;

use App\App\Doctrine\Mapper\ServiceInstance\ServiceInstanceModelInterface;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Repository\ServiceInstance\ServiceInstanceCommandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;

class ServiceInstanceCommandRepository implements ServiceInstanceCommandRepositoryInterface
{
    /** @var ServiceInstanceModelInterface */
    private $serviceInstanceModelMapper;
    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * ServiceInstanceCommandRepository constructor.
     * @param ServiceInstanceModelInterface $serviceInstanceModelMapper
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ServiceInstanceModelInterface $serviceInstanceModelMapper,
        EntityManagerInterface $entityManager
    ) {
        $this->serviceInstanceModelMapper = $serviceInstanceModelMapper;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ServiceInstanceInterface $serviceInstance
     */
    public function create(ServiceInstanceInterface $serviceInstance): void
    {
        /** @var ServiceInstanceEntity $serviceInstanceEntity */
        $serviceInstanceEntity = $this->serviceInstanceModelMapper->mapNew($serviceInstance);

        $this->entityManager->persist($serviceInstanceEntity);
        $this->entityManager->flush();
    }
}
