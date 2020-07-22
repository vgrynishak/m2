<?php

namespace App\App\Doctrine\Mapper\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate as ReportTemplateEntity;

interface ReportTemplateModelInterface
{
    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateEntity
     */
    public function map(ReportTemplateInterface $reportTemplate): ReportTemplateEntity;

    /**
     * @param ReportTemplateInterface $reportTemplate
     * @return ReportTemplateEntity
     */
    public function mapNew(ReportTemplateInterface $reportTemplate): ReportTemplateEntity;
}
