<?php

namespace App\App\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus;
use App\App\Mapper\ReportTemplate\DoctrineEntityReportTemplateStatusMapper;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ReportTemplateStatusQueryRepository implements ReportTemplateStatusQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var DoctrineEntityReportTemplateStatusMapper */
    private $mapper;

    /**
     * ReportTemplateStatusQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param DoctrineEntityReportTemplateStatusMapper $mapper
     */
    public function __construct(EntityManagerInterface $entityManager, DoctrineEntityReportTemplateStatusMapper $mapper)
    {
        $this->entityManager = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * @param string $id
     * @return ReportTemplateStatus
     */
    public function find(string $id): ReportTemplateStatus
    {
        $reportTemplateVersionStatusRepositoryORM =
            $this->entityManager->getRepository('App:ReportTemplate\ReportTemplateVersionStatus');

        /** @var ReportTemplateVersionStatus $reportTemplateVersionStatus */
        $reportTemplateVersionStatusORM = $reportTemplateVersionStatusRepositoryORM->findOneBy(['id' => $id]);

        return $this->mapper->map($reportTemplateVersionStatusORM);
    }
}
