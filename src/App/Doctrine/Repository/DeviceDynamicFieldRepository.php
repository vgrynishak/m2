<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\DeviceDynamicField;
use App\Core\Model\Device\DeviceId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DeviceDynamicField|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceDynamicField|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceDynamicField[]    findAll()
 * @method DeviceDynamicField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceDynamicFieldRepository extends ServiceEntityRepository
{
    /**
     * DeviceDynamicFieldRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceDynamicField::class);
    }

    /**
     * @param DeviceId $deviceId
     * @return mixed
     */
    public function findAllByDeviceId(DeviceId $deviceId)
    {
        $query = $this->createQueryBuilder('ddf');
        $query->where('ddf.device = :device');

        $query->setParameter('device', $deviceId->getValue());

        return $query->getQuery()->getResult();
    }
}
