<?php

namespace App\App\Doctrine\Mapper\Section;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\App\Doctrine\Entity\User;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionRepository;
use App\App\Doctrine\Repository\SectionRepository;
use App\App\Doctrine\Repository\UserRepository;
use App\App\Mapper\Exception\EntityNotFound;
use App\Core\Model\Section\SectionInterface;
use App\App\Doctrine\Entity\Section as SectionEntity;

class SectionModel implements SectionModelInterface
{
    /** @var SectionRepository */
    private $sectionRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ReportTemplateVersionRepository */
    private $reportTemplateVersionRepository;

    /**
     * SectionModel constructor.
     * @param SectionRepository $sectionRepository
     * @param UserRepository $userRepository
     * @param ReportTemplateVersionRepository $reportTemplateVersionRepository
     */
    public function __construct(
        SectionRepository $sectionRepository,
        UserRepository $userRepository,
        ReportTemplateVersionRepository $reportTemplateVersionRepository
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->userRepository = $userRepository;
        $this->reportTemplateVersionRepository = $reportTemplateVersionRepository;
    }

    /**
     * @param SectionModelInterface $sectionModel
     * @return SectionEntity
     * @throws EntityNotFound
     */
    public function map(SectionInterface $sectionModel): SectionEntity
    {
        /** @var SectionEntity $sectionEntity */
        $sectionEntity = $this->findSection($sectionModel);
        if (!$sectionEntity instanceof SectionEntity) {
            throw new EntityNotFound("Section entity was not found");
        }
        $this->mapGeneralInfo($sectionModel, $sectionEntity);

        return $sectionEntity;
    }

    /**
     * @param SectionModelInterface $sectionModel
     * @return SectionEntity
     */
    public function mapNew(SectionInterface $sectionModel): SectionEntity
    {
        /** @var SectionEntity $sectionEntity */
        $sectionEntity = new SectionEntity();
        $sectionEntity->setId($sectionModel->getId()->getValue());
        $this->mapCreatedInfo($sectionModel, $sectionEntity);
        $this->mapGeneralInfo($sectionModel, $sectionEntity);

        return $sectionEntity;
    }

    /**
     * @param SectionModelInterface $model
     * @param SectionEntity $entity
     */
    private function mapCreatedInfo(SectionInterface $model, SectionEntity $entity)
    {
        /** @var User $createdBy */
        $createdBy = $this->userRepository->find($model->getCreatedBy()->getId());
        $entity->setCreatedBy($createdBy);
        $entity->setCreatedAt($model->getCreatedAt());
    }

    /**
     * @param SectionModelInterface $model
     * @param SectionEntity $entity
     */
    private function mapGeneralInfo(SectionInterface $model, SectionEntity $entity)
    {
        /** @var User $modifiedBy */
        $modifiedBy = $this->userRepository->find($model->getModifiedBy()->getId());
        $entity->setModifiedBy($modifiedBy);
        $entity->setUpdatedAt($model->getModifiedAt());

        /** @var ReportTemplateVersion $reportTemplateVersion */
        $reportTemplateVersion = $this->reportTemplateVersionRepository
            ->find($model->getReportTemplateId()->getValue());

        $entity->setReportTemplateVersion($reportTemplateVersion);
        $entity->setPosition($model->getPosition());
        $entity->setPrintable($model->isPrintable());
        $entity->setTitle($model->getTitle());
    }

    /**
     * @param SectionModelInterface $sectionModel
     * @return SectionEntity|null
     */
    private function findSection(SectionInterface $sectionModel)
    {
        $findParams = ['reportTemplateVersion' => $sectionModel->getReportTemplateId()->getValue()];
        if ($sectionModel->getReportTemplateId()) {
            $findParams['position'] = $sectionModel->getPosition();
        }
        return $this->sectionRepository->findOneBy($findParams);
    }
}
