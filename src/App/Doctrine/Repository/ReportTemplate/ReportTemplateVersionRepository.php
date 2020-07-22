<?php

namespace App\App\Doctrine\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method ReportTemplateVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportTemplateVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportTemplateVersion[]    findAll()
 * @method ReportTemplateVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportTemplateVersionRepository extends ServiceEntityRepository
{
    /**
     * ReportTemplateVersionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportTemplateVersion::class);
    }

    /**
     * @param ServiceId $serviceId
     *
     * @return mixed
     */
    public function findListByServiceId(ServiceId $serviceId)
    {
        $query = $this->createQueryBuilder('rtv');
        $query->leftJoin('rtv.reportTemplate', 'rt')
            ->where('rt.service = :service');

        $query->setParameter('service', $serviceId->getValue());

        return $query->getQuery()->getResult();
    }

    /**
     * @param ReportTemplateId $reportTemplateId
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findByReportTemplateId(ReportTemplateId $reportTemplateId)
    {
        $query = $this->createQueryBuilder('rtv');
        $query->leftJoin('rtv.reportTemplate', 'rt')
            ->where('rt.id = :reportTemplateId');

        $query->setParameter('reportTemplateId', $reportTemplateId->getValue());

        return $query->getQuery()->getOneOrNullResult();
    }
}
