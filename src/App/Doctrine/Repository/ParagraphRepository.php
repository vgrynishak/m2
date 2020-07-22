<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\Paragraph;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Section\SectionId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Paragraph|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paragraph|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paragraph[]    findAll()
 * @method Paragraph[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParagraphRepository extends ServiceEntityRepository
{
    /**
     * ParagraphRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paragraph::class);
    }

    /**
     * @param SectionId $id
     * @return int
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMaxPositionForRoot(SectionId $id): int
    {
        $query = $this->createQueryBuilder('paragraph');
        $query
            ->select('MAX(paragraph.position)')
            ->where('paragraph.section = :id')
            ->andWhere($query->expr()->isNull('paragraph.parent'))
            ->setParameter('id', $id->getValue());

        return $query->getQuery()->getSingleScalarResult() ?? 0;
    }

    /**
     * @param ParagraphId $id
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPositionForChild(ParagraphId $id): int
    {
        $query = $this->createQueryBuilder('paragraph');
        $query
            ->select('MAX(paragraph.position)')
            ->where('paragraph.parent = :id')
            ->andWhere($query->expr()->isNotNull('paragraph.parent'))
            ->setParameter('id', $id->getValue());

        return $query->getQuery()->getSingleScalarResult() ?? 0;
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxPosition(BaseParagraphInterface $paragraph): int
    {
        if ($paragraph instanceof ChildParagraphInterface) {
            /** @var int $level */
            $level = $paragraph->getLevel();
            /** @var BaseParagraphInterface|null $parent */
            $parent = $paragraph->getParent()->getValue();
        } else {
            /** @var int $level */
            $level = 1;
            /** @var BaseParagraphInterface|null $parent */
            $parent = null;
        }

        $query = $this->createQueryBuilder('p');
        $query
            ->select('MAX(p.position)')
            ->where('p.section = :section')
            ->andWhere('p.level = :level')
            ->setParameters(
                [
                    'section' => $paragraph->getSectionId()->getValue(),
                    'level' => $level
                ]
            );

        if ($parent) {
            $query
                ->andWhere('p.parent = :parent')
                ->setParameter('parent', $parent);
        }

        return $query->getQuery()->getSingleScalarResult() ?? 0;
    }

    /**
     * @param SectionId $sectionId
     * @return mixed
     */
    public function findRootListBySectionId(SectionId $sectionId)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.section', 'ps')
            ->where('ps.id = :sectionId')
            ->andWhere('p.parent is NULL')
            ->orderBy('p.position', 'ASC')
        ;

        $query->setParameter('sectionId', $sectionId->getValue());

        return $query->getQuery()->getResult();
    }

    /**
     * @param ParagraphId $parentId
     * @return mixed
     */
    public function getChildrenListByParentId(ParagraphId $parentId)
    {
        $query = $this->createQueryBuilder('p');
        $query->leftJoin('p.parent', 'pp')
            ->where('pp.id = :parentId')
            ->orderBy('p.position', 'ASC')
        ;

        $query->setParameter('parentId', $parentId->getValue());

        return $query->getQuery()->getResult();
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedDecreaseInPosition(BaseParagraphInterface $paragraph, int $positionToChange)
    {
        if ($paragraph instanceof ChildParagraphInterface) {
            /** @var int $level */
            $level = $paragraph->getLevel();
            /** @var BaseParagraphInterface|null $parent */
            $parent = $paragraph->getParent()->getValue();
        } else {
            /** @var int $level */
            $level = 1;
            /** @var BaseParagraphInterface|null $parent */
            $parent = null;
        }

        $query = $this->createQueryBuilder('p');
        $query->where('p.section = :section')
            ->andWhere('p.level = :level')
            ->andWhere('p.position > :positionIsChanging')
            ->andWhere('p.position <= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $paragraph->getPosition(),
                    'positionToChange' => $positionToChange,
                    'section' => $paragraph->getSectionId()->getValue(),
                    'level' => $level
                ]
            );

        if ($parent) {
            $query
                ->andWhere('p.parent = :parent')
                ->setParameter('parent', $parent);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param BaseParagraphInterface $paragraph
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedIncreaseInPosition(BaseParagraphInterface $paragraph, int $positionToChange)
    {
        if ($paragraph instanceof ChildParagraphInterface) {
            /** @var int $level */
            $level = $paragraph->getLevel();
            /** @var BaseParagraphInterface|null $parent */
            $parent = $paragraph->getParent()->getValue();
        } else {
            /** @var int $level */
            $level = 1;
            /** @var BaseParagraphInterface|null $parent */
            $parent = null;
        }

        $query = $this->createQueryBuilder('p');
        $query->where('p.section = :section')
            ->andWhere('p.level = :level')
            ->andWhere('p.position < :positionIsChanging')
            ->andWhere('p.position >= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $paragraph->getPosition(),
                    'positionToChange' => $positionToChange,
                    'section' => $paragraph->getSectionId()->getValue(),
                    'level' => $level
                ]
            );
        if ($parent) {
            $query
                ->andWhere('p.parent = :parent')
                ->setParameter('parent', $parent);
        }

        return $query->getQuery()->getResult();
    }
}
