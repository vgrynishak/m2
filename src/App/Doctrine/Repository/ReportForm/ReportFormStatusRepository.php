<?php

namespace App\App\Doctrine\Repository\ReportForm;

use App\App\Doctrine\Entity\ReportForm\ReportFormStatus\ReportFormStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportFormStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportFormStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportFormStatus[]    findAll()
 * @method ReportFormStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportFormStatusRepository extends ServiceEntityRepository
{
    /**
     * ReportFormStatusRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportFormStatus::class);
    }
}
