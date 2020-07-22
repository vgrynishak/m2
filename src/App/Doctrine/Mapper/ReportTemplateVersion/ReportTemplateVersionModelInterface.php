<?php

namespace App\App\Doctrine\Mapper\ReportTemplateVersion;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion as ReportTemplateVersionEntity;

interface ReportTemplateVersionModelInterface
{
    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateVersionEntity
     */
    public function map(ReportTemplateInterface $reportTemplate): ReportTemplateVersionEntity;

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateVersionEntity
     */
    public function mapNew(ReportTemplateInterface $reportTemplate): ReportTemplateVersionEntity;
}
