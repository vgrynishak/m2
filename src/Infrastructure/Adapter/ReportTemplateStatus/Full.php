<?php

namespace App\Infrastructure\Adapter\ReportTemplateStatus;

use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;
use App\Infrastructure\Adapter\DTO\ReportTemplateStatus\Full as FullRTStatusDTO;

class Full
{
    /**
     * @param ReportTemplateStatusInterface $status
     * @return FullRTStatusDTO
     */
    public static function adapt(ReportTemplateStatusInterface $status): FullRTStatusDTO
    {
        /** @var FullRTStatusDTO $fullStatus */
        $fullStatus = new FullRTStatusDTO(
            $status->getId(),
            $status->getName(),
            $status->getDescription()
        );

        return $fullStatus;
    }
}
