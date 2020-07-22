<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface ArchiveReportTemplateUseCaseInterface
{
    /**
     * @param ArchiveReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     */
    public function archive(ArchiveReportTemplateCommandInterface $command): ReportTemplateInterface;
}
