<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\ServiceInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ServiceInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceInstance[]    findAll()
 * @method ServiceInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceInstanceRepository extends ServiceEntityRepository
{
    /**
     * ServiceInstanceRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceInstance::class);
    }

}
