<?php

namespace App\App\Mapper\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate as ReportTemplateEntity;
use App\App\Factory\ReportTemplate\ReportTemplateFactoryInterface;
use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\App\Mapper\Service\DoctrineEntityServiceMapper;
use App\Core\Model\Device\Device;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\Core\Model\Service\Service;
use App\Core\Model\User\User;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Exception;
use PhpCollection\CollectionInterface;

class ReportTemplateVersionEntityMapper implements ReportTemplateVersionEntityMapperInterface
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepositoryInterface;
    /** @var DoctrineEntityReportTemplateStatusMapper */
    private $entityReportTemplateStatusMapper;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $entityDeviceMapper;
    /** @var DoctrineEntityServiceMapper */
    private $entityServiceMapper;
    /** @var ReportTemplateFactoryInterface */
    private $reportTemplateFactory;

    /**
     * ReportTemplateVersionEntityMapper constructor.
     * @param UserQueryRepositoryInterface $userQueryRepositoryInterface
     * @param DoctrineEntityReportTemplateStatusMapper $entityReportTemplateStatusMapper
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     * @param DoctrineEntityDeviceMapperInterface $deviceMapper
     * @param DoctrineEntityServiceMapper $serviceMapper
     * @param ReportTemplateFactoryInterface $reportTemplateFactory
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepositoryInterface,
        DoctrineEntityReportTemplateStatusMapper $entityReportTemplateStatusMapper,
        SectionQueryRepositoryInterface $sectionQueryRepository,
        DoctrineEntityDeviceMapperInterface $deviceMapper,
        DoctrineEntityServiceMapper $serviceMapper,
        ReportTemplateFactoryInterface $reportTemplateFactory
    ) {
        $this->userQueryRepositoryInterface = $userQueryRepositoryInterface;
        $this->entityReportTemplateStatusMapper = $entityReportTemplateStatusMapper;
        $this->sectionQueryRepository = $sectionQueryRepository;
        $this->entityDeviceMapper = $deviceMapper;
        $this->entityServiceMapper = $serviceMapper;
        $this->reportTemplateFactory = $reportTemplateFactory;
    }

    /**
     * @param ReportTemplateVersion $reportTemplateVersion
     * @return ReportTemplateInterface
     * @throws InvalidDeviceIdException
     * @throws InvalidDivisionIdException
     * @throws Exception
     */
    public function map(ReportTemplateVersion $reportTemplateVersion) : ReportTemplateInterface
    {
        /** @var ReportTemplateVersionStatus $reportTemplateStatusEntity */
        $reportTemplateStatusEntity = $reportTemplateVersion->getReportTemplateVersionStatus();
        /** @var User $userModified */
        $userModified = $this->userQueryRepositoryInterface->find($reportTemplateVersion->getModifiedBy()->getId());
        /** @var User $userCreated */
        $userCreated = $this->userQueryRepositoryInterface->find($reportTemplateVersion->getCreatedBy()->getId());
        /** @var ReportTemplateStatus $reportTemplateStatusModel */
        $reportTemplateStatusModel = $this->entityReportTemplateStatusMapper->map($reportTemplateStatusEntity);
        /** @var CollectionInterface|null $sectionsModel */
        $sectionsModel =
            $this->sectionQueryRepository->findListByReportTemplateVersionId($reportTemplateVersion->getId());
        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = $reportTemplateVersion->getReportTemplate();
        /** @var Service $service */
        $service = $this->entityServiceMapper->map($reportTemplateEntity->getService());
        /** @var Device $device */
        $device = $this->entityDeviceMapper->map($reportTemplateEntity->getDevice());

        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = $reportTemplateVersion->getReportTemplate();

        /** @var ReportTemplate $reportTemplateModel */
        $reportTemplateModel = $this->reportTemplateFactory->make(
            $reportTemplateVersion->getId(),
            $reportTemplateEntity->getName(),
            $reportTemplateEntity->getService()->getId(),
            $reportTemplateEntity->getDevice()->getId()
        );

        $reportTemplateModel->setDescription($reportTemplateEntity->getDescription());
        $reportTemplateModel->setModifiedBy($userModified);
        $reportTemplateModel->setCreatedBy($userCreated);
        $reportTemplateModel->setUpdatedAt($reportTemplateVersion->getUpdatedAt());
        $reportTemplateModel->setCreatedAt($reportTemplateVersion->getCreatedAt());
        $reportTemplateModel->setStatus($reportTemplateStatusModel);
        $reportTemplateModel->setSections($sectionsModel);
        $reportTemplateModel->setService($service);
        $reportTemplateModel->setDevice($device);

        return $reportTemplateModel;
    }
}
