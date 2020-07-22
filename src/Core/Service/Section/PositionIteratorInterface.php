<?php

namespace App\Core\Service\Section;

use App\Core\Model\ReportTemplate\ReportTemplateId;

interface PositionIteratorInterface
{
    /**
     * @param ReportTemplateId $reportTemplateId
     * @return int
     */
    public function next(ReportTemplateId $reportTemplateId): int;
}
