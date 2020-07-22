<?php

namespace App\App\Doctrine\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReportTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportTemplate[]    findAll()
 * @method ReportTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportTemplate::class);
    }
}
