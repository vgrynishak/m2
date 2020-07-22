<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface DeleteReportTemplateUseCaseInterface
{
    /**
     * @param DeleteReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     */
    public function delete(DeleteReportTemplateCommandInterface $command): ReportTemplateInterface;
}
