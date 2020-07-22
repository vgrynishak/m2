<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\StyleTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class StyleTemplateRepository
 * @package App\App\Doctrine\Repository
 */
class StyleTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StyleTemplate::class);
    }
}
