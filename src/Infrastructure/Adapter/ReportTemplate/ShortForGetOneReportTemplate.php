<?php

namespace App\Infrastructure\Adapter\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Infrastructure\Adapter\DTO\ReportTemplate\GetOne as RTShortDTO;
use App\Infrastructure\Adapter\DTO\Section\ShortForGetOneReportTemplate as ShortSectionForGetOneRTDTO;
use App\Infrastructure\Adapter\Section\ShortForGetOneReportTemplate as SectionForGetOneRTAdapter;
use PhpCollection\CollectionInterface;

class ShortForGetOneReportTemplate
{
    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return array
     */
    public static function adapt(ReportTemplateInterface $reportTemplate): array
    {
        /** @var RTShortDTO $shrotForGetOneRT */
        $shortForGetOneRT = new RTShortDTO(
            $reportTemplate->getId()->getValue(),
            $reportTemplate->getName(),
            $reportTemplate->getService()->getName(),
            $reportTemplate->getStatus()->getId()
        );

        $shortForGetOneRT->setDescription($reportTemplate->getDescription());
        if ($reportTemplate->getSections() instanceof CollectionInterface) {
            /** @var ShortSectionForGetOneRTDTO[] $shortSectionsDTO */
            $shortSectionsDTO = SectionForGetOneRTAdapter::adaptCollection($reportTemplate->getSections());
            $shortForGetOneRT->setSections($shortSectionsDTO);
        }

        return ['resultReportTemplate' => $shortForGetOneRT];
    }
}
