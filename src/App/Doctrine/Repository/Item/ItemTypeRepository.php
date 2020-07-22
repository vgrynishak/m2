<?php

namespace App\App\Doctrine\Repository\Item;

use App\App\Doctrine\Entity\Item\ItemType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemType[]    findAll()
 * @method ItemType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemType::class);
    }

    /**
     * @param array $excepted
     * @return mixed
     */
    public function findAllExcepted(array $excepted = [])
    {
        $qb = $this->createQueryBuilder('i');
        $qb->where($qb->expr()->notIn('i.id', $excepted));

        return $qb->getQuery()->getResult();
    }
}
