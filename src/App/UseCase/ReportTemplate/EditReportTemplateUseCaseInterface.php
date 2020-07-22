<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface EditReportTemplateUseCaseInterface
{
    /**
     * @param EditReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     */
    public function edit(EditReportTemplateCommandInterface $command): ReportTemplateInterface;
}
