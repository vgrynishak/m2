<?php

namespace App\App\Mapper\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateStatus;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus as ReportTemplateStatusORM;

class DoctrineEntityReportTemplateStatusMapper
{
    /**
     * @param ReportTemplateStatusORM $status
     * @return ReportTemplateStatus|null
     */
    public function map(ReportTemplateStatusORM $status): ?ReportTemplateStatus
    {
        if (!$status) {
            return null;
        }

        $reportTemplateStatus = new ReportTemplateStatus(
            $status->getId(),
            $status->getName(),
            $status->getDescription()
        );

        return $reportTemplateStatus;
    }
}
