<?php

namespace App\App\Doctrine\Repository\ReportForm;

use App\App\Doctrine\Entity\ReportForm\ReportForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportForm[]    findAll()
 * @method ReportForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportFormRepository extends ServiceEntityRepository
{
    /**
     * ReportFormRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportForm::class);
    }
}
