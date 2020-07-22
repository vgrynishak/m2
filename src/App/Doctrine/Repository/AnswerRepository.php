<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\Answer;
use App\App\Doctrine\Entity\Item\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @param Item $item
     * @return mixed
     */
    public function findByItemIdSortedByPosition(Item $item)
    {
        return $this
            ->createQueryBuilder('answer')
            ->where('answer.item = :id')
            ->setParameter('id', $item)
            ->orderBy('answer.position', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
