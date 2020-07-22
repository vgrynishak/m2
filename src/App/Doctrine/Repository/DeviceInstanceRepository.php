<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\DeviceInstance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DeviceInstance|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceInstance|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceInstance[]    findAll()
 * @method DeviceInstance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceInstanceRepository extends ServiceEntityRepository
{
    /**
     * DeviceInstanceRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceInstance::class);
    }

}
