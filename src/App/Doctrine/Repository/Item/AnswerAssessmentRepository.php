<?php

namespace App\App\Doctrine\Repository\Item;

use App\App\Doctrine\Entity\Item\AnswerAssessment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnswerAssessment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerAssessment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerAssessment[]    findAll()
 * @method AnswerAssessment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerAssessmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerAssessment::class);
    }
}
