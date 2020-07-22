<?php

namespace App\App\Doctrine\Mapper\ReportTemplate;

use App\App\Component\UUID\UUID;
use App\App\Doctrine\Entity\Device;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion as ReportTemplateVersionEntity;
use App\App\Doctrine\Entity\Service;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionRepository;
use App\App\Mapper\Exception\EntityNotFound;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate as ReportTemplateEntity;
use App\App\Doctrine\Repository\ServiceRepository;
use Exception;

class ReportTemplateModel implements ReportTemplateModelInterface
{
    /** @var ServiceRepository */
    private $serviceRepository;
    /** @var DeviceRepository */
    private $deviceRepository;
    /** @var ReportTemplateVersionRepository */
    private $reportTemplateVersionRepository;

    /**
     * ReportTemplateModel constructor.
     * @param ServiceRepository $serviceRepository
     * @param DeviceRepository $deviceRepository
     * @param ReportTemplateVersionRepository $reportTemplateVersionRepository
     */
    public function __construct(
        ServiceRepository $serviceRepository,
        DeviceRepository $deviceRepository,
        ReportTemplateVersionRepository $reportTemplateVersionRepository
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->deviceRepository = $deviceRepository;
        $this->reportTemplateVersionRepository = $reportTemplateVersionRepository;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateEntity
     * @throws EntityNotFound
     */
    public function map(ReportTemplateInterface $reportTemplate) : ReportTemplateEntity
    {
        /** @var ReportTemplateVersionEntity $reportTemplateVersionEntity */
        $reportTemplateVersionEntity =
            $this->reportTemplateVersionRepository->find($reportTemplate->getId()->getValue());
        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = $reportTemplateVersionEntity->getReportTemplate();
        if (!$reportTemplateEntity instanceof ReportTemplateEntity) {
            throw new EntityNotFound("Report Template entity not found");
        }
        $this->mapGeneralInfo($reportTemplate, $reportTemplateEntity);

        return $reportTemplateEntity;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateEntity
     * @throws Exception
     */
    public function mapNew(ReportTemplateInterface $reportTemplate) : ReportTemplateEntity
    {
        /** @var ReportTemplateEntity $reportTemplateEntity */
        $reportTemplateEntity = new ReportTemplateEntity();
        $this->mapCreatedInfo($reportTemplate, $reportTemplateEntity);
        $this->mapGeneralInfo($reportTemplate, $reportTemplateEntity);

        return $reportTemplateEntity;
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @param ReportTemplateEntity $reportTemplateEntity
     * @throws Exception
     */
    private function mapCreatedInfo(ReportTemplateInterface $reportTemplate, ReportTemplateEntity $reportTemplateEntity)
    {
        $reportTemplateEntity->setId((new UUID())->getValue());
        $reportTemplateEntity->setCreatedAt($reportTemplate->getCreatedAt());

        /** @var Service $service */
        $service = $this->serviceRepository->find($reportTemplate->getServiceId()->getValue());
        $reportTemplateEntity->setService($service);

        /** @var Device $device */
        $device = $this->deviceRepository->find($reportTemplate->getDeviceId()->getValue());
        $reportTemplateEntity->setDevice($device);
    }

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @param ReportTemplateEntity $reportTemplateEntity
     */
    private function mapGeneralInfo(ReportTemplateInterface $reportTemplate, ReportTemplateEntity $reportTemplateEntity)
    {
        $reportTemplateEntity->setName($reportTemplate->getName());
        $reportTemplateEntity->setDescription($reportTemplate->getDescription());
    }
}
