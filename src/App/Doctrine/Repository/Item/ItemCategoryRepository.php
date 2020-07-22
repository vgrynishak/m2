<?php

namespace App\App\Doctrine\Repository\Item;

use App\App\Doctrine\Entity\Item\ItemCategory;
use App\Core\Model\Paragraph\ParagraphId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ItemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemCategory[]    findAll()
 * @method ItemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemCategory::class);
    }

    /**
     * @return mixed
     */
    public function findAllSortedByPosition()
    {
        return $this
            ->createQueryBuilder('category')
            ->orderBy('category.position', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
