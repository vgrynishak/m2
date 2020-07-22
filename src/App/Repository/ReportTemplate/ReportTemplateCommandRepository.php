<?php

namespace App\App\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateCommandRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusQueryRepositoryInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateStatusRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate as ReportTemplateEntity;
use App\App\Doctrine\Mapper\ReportTemplate\ReportTemplateModelInterface as RtModelToEntityMapper;
use App\App\Doctrine\Mapper\ReportTemplateVersion\ReportTemplateVersionModelInterface as RtModelToRtVersionEntityMapper;
use App\App\Mapper\Exception\EntityNotFound;
use Exception;

class ReportTemplateCommandRepository implements ReportTemplateCommandRepositoryInterface
{
    /** @var EntityManagerInterface  */
    protected $entityManager;
    /** @var RtModelToEntityMapper */
    private $rtModelToEntityMapper;
    /** @var RtModelToRtVersionEntityMapper */
    private $rtModelToRtVersionEntityMapper;
    /** @var ReportTemplateStatusRepositoryInterface */
    private $reportTemplateStatusQueryRepository;

    /**
     * ReportTemplateRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param RtModelToEntityMapper $rtModelToEntityMapper
     * @param RtModelToRtVersionEntityMapper $rtModelToRtVersionEntityMapper
     * @param ReportTemplateStatusQueryRepositoryInterface $statusQueryRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RtModelToEntityMapper $rtModelToEntityMapper,
        RtModelToRtVersionEntityMapper $rtModelToRtVersionEntityMapper,
        ReportTemplateStatusQueryRepositoryInterface $statusQueryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->rtModelToEntityMapper = $rtModelToEntityMapper;
        $this->rtModelToRtVersionEntityMapper = $rtModelToRtVersionEntityMapper;
        $this->reportTemplateStatusQueryRepository = $statusQueryRepository;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @throws Exception
     */
    public function create(ReportTemplateInterface $reportTemplate)
    {
        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = $this->rtModelToEntityMapper->mapNew($reportTemplate);
        $this->entityManager->persist($reportTemplateEntity);

        /** @var ReportTemplateVersion $reportTemplateVersionEntity */
        $reportTemplateVersionEntity = $this->rtModelToRtVersionEntityMapper->mapNew($reportTemplate);
        $this->entityManager->persist($reportTemplateVersionEntity);

        $reportTemplateVersionEntity->setReportTemplate($reportTemplateEntity);

        $this->entityManager->flush();
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     */
    public function update(ReportTemplateInterface $reportTemplate)
    {
        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = $this->rtModelToEntityMapper->map($reportTemplate);
        /** @var ReportTemplateVersion $reportTemplateVersionEntity */
        $reportTemplateVersionEntity = $this->rtModelToRtVersionEntityMapper->map($reportTemplate);

        $reportTemplateVersionEntity->setReportTemplate($reportTemplateEntity);

        $this->entityManager->flush();
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @throws Exception
     */
    public function createOrUpdate(ReportTemplateInterface $reportTemplate)
    {
        try {
            /** @var ReportTemplateEntity $reportTemplateEntity */
            $reportTemplateEntity = $this->rtModelToEntityMapper->map($reportTemplate);
        } catch (EntityNotFound $exception) {
            /** @var ReportTemplateEntity $reportTemplateEntity */
            $reportTemplateEntity = $this->rtModelToEntityMapper->mapNew($reportTemplate);
            $this->entityManager->persist($reportTemplateEntity);
        }

        try {
            /** @var ReportTemplateVersion $reportTemplateVersionEntity */
            $reportTemplateVersionEntity = $this->rtModelToRtVersionEntityMapper->map($reportTemplate);
        } catch (EntityNotFound $exception) {
            /** @var ReportTemplateVersion $reportTemplateVersionEntity */
            $reportTemplateVersionEntity = $this->rtModelToRtVersionEntityMapper->mapNew($reportTemplate);
            $this->entityManager->persist($reportTemplateVersionEntity);
        }

        $reportTemplateVersionEntity->setReportTemplate($reportTemplateEntity);

        $this->entityManager->flush();
    }
}
