<?php

namespace App\App\Doctrine\Mapper\ReportTemplateVersion;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion as ReportTemplateVersionEntity;
use App\App\Doctrine\Entity\User;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionStatusRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionRepository;
use App\App\Mapper\Exception\EntityNotFound;
use Exception;

class ReportTemplateVersionModel implements ReportTemplateVersionModelInterface
{
    /** @var ReportTemplateVersionRepository */
    private $reportTemplateVersionRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ReportTemplateVersionStatusRepository */
    private $reportTemplateVersionStatusRepository;

    /**
     * ReportTemplateModel constructor.
     * @param ReportTemplateVersionRepository $reportTemplateVersionRepository
     * @param UserRepository $userRepository
     * @param ReportTemplateVersionStatusRepository $reportTemplateVersionStatusRepository
     */
    public function __construct(
        ReportTemplateVersionRepository $reportTemplateVersionRepository,
        UserRepository $userRepository,
        ReportTemplateVersionStatusRepository $reportTemplateVersionStatusRepository
    ) {
        $this->reportTemplateVersionRepository = $reportTemplateVersionRepository;
        $this->userRepository = $userRepository;
        $this->reportTemplateVersionStatusRepository = $reportTemplateVersionStatusRepository;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     *
     * @return ReportTemplateVersionEntity
     * @throws EntityNotFound
     */
    public function map(ReportTemplateInterface $reportTemplate) : ReportTemplateVersionEntity
    {
        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        $reportTemplateVersionEntity =
            $this->reportTemplateVersionRepository->find($reportTemplate->getId()->getValue());
        if (!$reportTemplateVersionEntity instanceof ReportTemplateVersionEntity) {
            throw new EntityNotFound("ReportTemplateVersion entity not found");
        }
        $this->mapGeneralInfo($reportTemplate, $reportTemplateVersionEntity);

        return $reportTemplateVersionEntity;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateVersionEntity
     * @throws Exception
     */
    public function mapNew(ReportTemplateInterface $reportTemplate) : ReportTemplateVersionEntity
    {
        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        $reportTemplateVersionEntity = new ReportTemplateVersionEntity();
        $reportTemplateVersionEntity->setId($reportTemplate->getId()->getValue());
        $this->mapCreatedInfo($reportTemplate, $reportTemplateVersionEntity);
        $this->mapGeneralInfo($reportTemplate, $reportTemplateVersionEntity);

        return $reportTemplateVersionEntity;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @param ReportTemplateVersionEntity $reportTemplateVersionEntity
     */
    private function mapCreatedInfo(
        ReportTemplateInterface $reportTemplate,
        ReportTemplateVersionEntity $reportTemplateVersionEntity
    ) {
        /** @var User $createdBy */
        $createdBy = $this->userRepository->find($reportTemplate->getCreatedBy()->getId());
        $reportTemplateVersionEntity->setCreatedBy($createdBy);
        $reportTemplateVersionEntity->setCreatedAt($reportTemplate->getCreatedAt());
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @param ReportTemplateVersionEntity $reportTemplateVersionEntity
     */
    private function mapGeneralInfo(
        ReportTemplateInterface $reportTemplate,
        ReportTemplateVersionEntity $reportTemplateVersionEntity
    ) {
        /** @var User $modifiedBy */
        $modifiedBy = $this->userRepository->find($reportTemplate->getModifiedBy()->getId());
        $reportTemplateVersionEntity->setModifiedBy($modifiedBy);
        $reportTemplateVersionEntity->setUpdatedAt($reportTemplate->getUpdatedAt());

        /** @var ReportTemplateVersionStatus $status */
        $status = $this->reportTemplateVersionStatusRepository->find($reportTemplate->getStatus()->getId());
        $reportTemplateVersionEntity->setReportTemplateVersionStatus($status);
        $reportTemplateVersionEntity->setVersionNumber($reportTemplate->getVersionNumber());
    }
}
