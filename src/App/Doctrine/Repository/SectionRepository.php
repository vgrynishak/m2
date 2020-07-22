<?php

namespace App\App\Doctrine\Repository;

use App\App\Doctrine\Entity\Section;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    /**
     * SectionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    /**
     * @param ReportTemplateId $id
     * @return mixed
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getMaxPosition(ReportTemplateId $id)
    {
        $query = $this->createQueryBuilder('section');
        $query->select('MAX(section.position)')->where('section.reportTemplateVersion = :id');
        $query->setParameter('id', $id->getValue());

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedDecreaseInPosition(SectionInterface $section, int $positionToChange)
    {
        $query = $this->createQueryBuilder('s');
        $query->where('s.reportTemplateVersion = :reportTemplateVersion')
            ->andWhere('s.position > :positionIsChanging')
            ->andWhere('s.position <= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $section->getPosition(),
                    'positionToChange' => $positionToChange,
                    'reportTemplateVersion' => $section->getReportTemplateId()->getValue()
                ]
            );

        return $query->getQuery()->getResult();
    }

    /**
     * @param SectionInterface $section
     * @param int $positionToChange
     * @return mixed
     */
    public function getListWhoNeedIncreaseInPosition(SectionInterface $section, int $positionToChange)
    {
        $query = $this->createQueryBuilder('s');
        $query->where('s.reportTemplateVersion = :reportTemplateVersion')
            ->andWhere('s.position < :positionIsChanging')
            ->andWhere('s.position >= :positionToChange')
            ->setParameters(
                [
                    'positionIsChanging' => $section->getPosition(),
                    'positionToChange' => $positionToChange,
                    'reportTemplateVersion' => $section->getReportTemplateId()->getValue()
                ]
            );

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $reportTemplateVersionId
     *
     * @return mixed
     */
    public function findListByReportTemplateVersionId(string $reportTemplateVersionId)
    {
        $query = $this->createQueryBuilder('s');
        $query->leftJoin('s.reportTemplateVersion', 'srtv')
            ->where('srtv.id = :reportTemplateVersionId')
            ->addOrderBy('s.position');

        $query->setParameter('reportTemplateVersionId', $reportTemplateVersionId);

        return $query->getQuery()->getResult();
    }
}
