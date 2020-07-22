<?php

namespace App\App\Doctrine\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReportTemplateVersionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportTemplateVersionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportTemplateVersionStatus[]    findAll()
 * @method ReportTemplateVersionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportTemplateVersionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportTemplateVersionStatus::class);
    }
}
