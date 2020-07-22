<?php

namespace App\App\Mapper\ReportTemplate;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface ReportTemplateVersionEntityMapperInterface
{
    public function map(ReportTemplateVersion $reportTemplateVersion) : ReportTemplateInterface;
}
