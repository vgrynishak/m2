<?php

namespace App\Core\Repository\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateStatus;

interface ReportTemplateStatusQueryRepositoryInterface
{
    public function find(string $id): ReportTemplateStatus;
}
