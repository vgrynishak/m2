<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\HeaderType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class HeaderTypeRepository extends ServiceEntityRepository
{
    /**
     * HeaderTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeaderType::class);
    }
}
