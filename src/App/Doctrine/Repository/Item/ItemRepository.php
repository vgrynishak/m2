<?php

namespace App\App\Doctrine\Repository\Item;

use App\App\Doctrine\Entity\Item\Item;
use App\Core\Model\Item\ItemInterface;
use App\Core\Model\Paragraph\ParagraphId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /**
     * @param ParagraphId $id
     * @return int|mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPosition(ParagraphId $id)
    {
        return $this
            ->createQueryBuilder('item')
            ->select('MAX(item.position)')
            ->where('item.paragraphId = :id')
            ->setParameter('id', $id->getValue())
            ->getQuery()
            ->getSingleScalarResult() ?? 0
        ;
    }

    /**
     * @param ParagraphId $id
     * @return mixed
     */
    public function findByParagraphIdSortedByPosition(ParagraphId $id)
    {
        return $this
                ->createQueryBuilder('item')
                ->where('item.paragraphId = :id')
                ->setParameter('id', $id->getValue())
                ->orderBy('item.position', 'ASC')
                ->getQuery()
                ->getResult()
            ;
    }

    /**
     * @param ItemInterface $item
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedDecreaseInPosition(ItemInterface $item, int $positionToChange)
    {
        return $this->createQueryBuilder('i')
            ->where('i.paragraphId = :paragraph')
            ->andWhere('i.position > :positionIsChanging')
            ->andWhere('i.position <= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $item->getPosition(),
                    'positionToChange' => $positionToChange,
                    'paragraph' => $item->getParagraphId()->getValue()
                ]
            )
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param ItemInterface $item
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedIncreaseInPosition(ItemInterface $item, int $positionToChange)
    {
        return $this->createQueryBuilder('i')
            ->where('i.paragraphId = :paragraph')
            ->andWhere('i.position < :positionIsChanging')
            ->andWhere('i.position >= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $item->getPosition(),
                    'positionToChange' => $positionToChange,
                    'paragraph' => $item->getParagraphId()->getValue()
                ]
            )
            ->getQuery()
            ->getResult()
            ;
    }
}
