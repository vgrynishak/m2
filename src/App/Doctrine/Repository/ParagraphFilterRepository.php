<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\ParagraphFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ParagraphFilter|null find($id, $lockMode = null, $lockVersion = null)
 */
class ParagraphFilterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParagraphFilter::class);
    }
}
