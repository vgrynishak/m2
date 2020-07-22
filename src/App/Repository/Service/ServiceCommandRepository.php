<?php

namespace App\App\Repository\Service;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Mapper\Service\ServiceModelInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Repository\Service\ServiceCommandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ServiceCommandRepository implements ServiceCommandRepositoryInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var ServiceModelInterface */
    private $serviceModelToEntityMapper;

    /**
     * ServiceCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param ServiceModelInterface $serviceModel
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ServiceModelInterface $serviceModel
    ) {
        $this->entityManager = $entityManager;
        $this->serviceModelToEntityMapper = $serviceModel;
    }

    /**
     * @param ServiceInterface $service
     */
    public function create(ServiceInterface $service)
    {
        /** @var ServiceEntity $serviceEntity */
        $serviceEntity = $this->serviceModelToEntityMapper->mapNew($service);

        $this->entityManager->persist($serviceEntity);
        $this->entityManager->flush();
    }
}
