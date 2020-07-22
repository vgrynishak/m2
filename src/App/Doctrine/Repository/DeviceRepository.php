<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\Device;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Device|null find($id, $lockMode = null, $lockVersion = null)
 * @method Device|null findOneBy(array $criteria, array $orderBy = null)
 * @method Device[]    findAll()
 * @method Device[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    /**
     * @return mixed
     */
    public function getAllDevicesOrderedByNameAsc()
    {
        $query = $this->createQueryBuilder('d');
        $query
            ->orderBy("d.name", "ASC")
        ;

        return $query->getQuery()->getResult();
    }
}
