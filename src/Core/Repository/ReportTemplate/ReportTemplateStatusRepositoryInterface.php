<?php

namespace App\Core\Repository\ReportTemplate;

use App\App\Component\UUID\UUID;
use App\Core\Model\ReportTemplate\ReportTemplateStatusInterface;

interface ReportTemplateStatusRepositoryInterface
{
    public function save(ReportTemplateStatusInterface $reportTemplateStatus);

    public function delete(UUID $id);
}
