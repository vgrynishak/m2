<?php

namespace App\App\Doctrine\Repository\Item;

use App\App\Doctrine\Entity\Item\InfoSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSource[]    findAll()
 * @method InfoSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoSource::class);
    }
}
