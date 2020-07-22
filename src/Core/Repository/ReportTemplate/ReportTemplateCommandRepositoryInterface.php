<?php

namespace App\Core\Repository\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface ReportTemplateCommandRepositoryInterface
{
    public function create(ReportTemplateInterface $reportTemplate);

    public function update(ReportTemplateInterface $reportTemplate);

    public function createOrUpdate(ReportTemplateInterface $reportTemplate);
}
