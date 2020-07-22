<?php

namespace App\App\Repository\Service;

use App\App\Doctrine\Entity\Service;
use App\App\Doctrine\Repository\ServiceRepository;
use App\App\Mapper\Service\DoctrineEntityServiceMapper;
use App\Core\Model\Service\ServiceId;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ServiceQueryRepository implements ServiceQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var DoctrineEntityServiceMapper */
    private $mapper;

    /**
     * ServiceQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DoctrineEntityServiceMapper $mapper
     */
    public function __construct(EntityManagerInterface $entityManager, DoctrineEntityServiceMapper $mapper)
    {
        $this->entityManager = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * @param ServiceId $serviceId
     * @return \App\Core\Model\Service\Service|null
     * @throws Exception
     */
    public function find(ServiceId $serviceId)
    {
        /** @var ServiceRepository $serviceRepository */
        $serviceRepository = $this->entityManager->getRepository('App:Service');
        /** @var Service $serviceORM */
        $serviceORM = $serviceRepository->find($serviceId->getValue());

        if (!$serviceORM instanceof Service) {
            return null;
        }

        return $this->mapper->map($serviceORM);
    }
}
