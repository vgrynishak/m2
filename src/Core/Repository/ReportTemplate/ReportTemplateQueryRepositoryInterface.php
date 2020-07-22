<?php

namespace App\Core\Repository\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion as ReportTemplateVersionEntity;
use App\Core\Model\ReportTemplate\ReportTemplate;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;

interface ReportTemplateQueryRepositoryInterface
{
    public function find(ReportTemplateId $id): ?ReportTemplate;

    public function findListByServiceId(ServiceId $serviceId): ?array;

    public function findIdByReportTemplateId(ReportTemplateId $id): ?ReportTemplateVersionEntity;
}
