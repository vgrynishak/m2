<?php

namespace App\App\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion as ReportTemplateVersionEntity;
use App\App\Mapper\ReportTemplate\ReportTemplateVersionEntityMapperInterface;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionRepository
    as DoctrineReportTemplateVersionRepository;

class ReportTemplateQueryRepository implements ReportTemplateQueryRepositoryInterface
{
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var ReportTemplateVersionEntityMapperInterface */
    protected $reportTemplateVersionEntityMapper;

    /**
     * ReportTemplateQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param ReportTemplateVersionEntityMapperInterface $reportTemplateVersionEntityMapper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ReportTemplateVersionEntityMapperInterface $reportTemplateVersionEntityMapper
    ) {
        $this->entityManager = $entityManager;
        $this->reportTemplateVersionEntityMapper = $reportTemplateVersionEntityMapper;
    }

    /**
     * @param ReportTemplateId $id
     * @return ReportTemplate|null
     */
    public function find(ReportTemplateId $id): ?ReportTemplate
    {
        /** @var DoctrineReportTemplateVersionRepository $reportTemplateVersionRepository */
        $reportTemplateVersionRepository = $this->entityManager->getRepository(
            "App:ReportTemplate\ReportTemplateVersion"
        );

        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        $reportTemplateVersionEntity = $reportTemplateVersionRepository->find($id->getValue());

        if (!$reportTemplateVersionEntity instanceof ReportTemplateVersionEntity) {
            return null;
        }

        /** @var ReportTemplate $reportTemplateModel */
        $reportTemplateModel = $this->reportTemplateVersionEntityMapper->map($reportTemplateVersionEntity);

        return $reportTemplateModel;
    }

    /**
     * @param ServiceId $serviceId
     * @return array|null
     */
    public function findListByServiceId(ServiceId $serviceId): ?array
    {
        /** @var DoctrineReportTemplateVersionRepository $reportTemplateVersionRepository */
        $reportTemplateVersionRepository = $this->entityManager->getRepository(
            "App:ReportTemplate\ReportTemplateVersion"
        );

        /** @var ReportTemplateVersionEntity[] $reportTemplatesVersionEntity */
        $reportTemplatesVersionEntity = $reportTemplateVersionRepository->findListByServiceId($serviceId);
        /** @var ReportTemplate[] $reportTemplates */
        $reportTemplates = [];

        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        foreach ($reportTemplatesVersionEntity as $reportTemplateVersionEntity) {
            $reportTemplates[] = $this->reportTemplateVersionEntityMapper->map($reportTemplateVersionEntity);
        }

        return $reportTemplates;
    }

    /**
     * @param ReportTemplateId $id
     * @return ReportTemplateVersionEntity|null
     */
    public function findIdByReportTemplateId(ReportTemplateId $id): ?ReportTemplateVersionEntity
    {
        /** @var DoctrineReportTemplateVersionRepository $reportTemplateVersionRepository */
        $reportTemplateVersionRepository = $this->entityManager->getRepository(
            "App:ReportTemplate\ReportTemplateVersion"
        );

        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        $reportTemplateVersionEntity =
            $reportTemplateVersionRepository->find($id->getValue());

        if (!$reportTemplateVersionEntity instanceof ReportTemplateVersionEntity) {
            return null;
        }

        return $reportTemplateVersionEntity;
    }
}
