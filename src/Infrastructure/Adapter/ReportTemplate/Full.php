<?php

namespace App\Infrastructure\Adapter\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Model\User\UserInterface;
use App\Infrastructure\Adapter\DTO\User\Full as UserFullDTO;
use App\Infrastructure\Adapter\DTO\Section\Full as SectionFullDTO;
use App\Infrastructure\Adapter\DTO\Device\Full as DeviceFullDTO;
use App\Infrastructure\Adapter\DTO\Service\Full as ServiceFullDTO;
use App\Infrastructure\Adapter\DTO\ReportTemplateStatus\Full as RTStatusFullDTO;
use App\Infrastructure\Adapter\DTO\ReportTemplate\Full as RTFullDTO;
use App\Infrastructure\Adapter\Device\Full as FullDeviceAdapter;
use App\Infrastructure\Adapter\Service\Full as FullServiceAdapter;
use App\Infrastructure\Adapter\ReportTemplateStatus\Full as FullRTStatusAdapter;
use App\Infrastructure\Adapter\User\Full as FullUserAdapter;
use App\Infrastructure\Adapter\Section\Full as FullSectionAdapter;
use PhpCollection\CollectionInterface;

class Full
{
    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return array
     */
    public static function adapt(ReportTemplateInterface $reportTemplate): array
    {
        /** @var DeviceFullDTO $fullDeviceDTO */
        $fullDeviceDTO = FullDeviceAdapter::adapt($reportTemplate->getDevice());
        /** @var ServiceFullDTO $fullServiceDTO */
        $fullServiceDTO = FullServiceAdapter::adapt($reportTemplate->getService());
        /** @var RTStatusFullDTO $fullRTStatusDTO */
        $fullRTStatusDTO = FullRTStatusAdapter::adapt($reportTemplate->getStatus());

        /** @var RTFullDTO $fullReportTemplate */
        $fullReportTemplate = new RTFullDTO(
            $reportTemplate->getId()->getValue(),
            $reportTemplate->getName(),
            $fullDeviceDTO,
            $fullServiceDTO,
            $fullRTStatusDTO
        );
        $fullReportTemplate->setDescription($reportTemplate->getDescription());
        $fullReportTemplate->setCreatedAt($reportTemplate->getCreatedAt()->getTimestamp());
        $fullReportTemplate->setUpdatedAt($reportTemplate->getUpdatedAt()->getTimestamp());
        $fullReportTemplate->setVersionNumber($reportTemplate->getVersionNumber());
        if ($reportTemplate->getCreatedBy() instanceof UserInterface) {
            /** @var UserFullDTO $fullUserDTO */
            $fullUserDTO = FullUserAdapter::adapt($reportTemplate->getCreatedBy());
            $fullReportTemplate->setCreatedBy($fullUserDTO);
        }
        if ($reportTemplate->getModifiedBy() instanceof UserInterface) {
            /** @var UserFullDTO $fullUserDTO */
            $fullUserDTO = FullUserAdapter::adapt($reportTemplate->getModifiedBy());
            $fullReportTemplate->setModifiedBy($fullUserDTO);
        }
        if ($reportTemplate->getSections() instanceof CollectionInterface) {
            /** @var SectionFullDTO[] $fullSectionsDTO */
            $fullSectionsDTO = FullSectionAdapter::adaptCollection($reportTemplate->getSections());
            $fullReportTemplate->setSections($fullSectionsDTO);
        }

        return ['resultReportTemplate' => $fullReportTemplate];
    }
}
