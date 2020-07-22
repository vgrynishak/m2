<?php

namespace App\App\UseCase\ReportTemplate;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface PublishReportTemplateUseCaseInterface
{
    /**
     * @param PublishReportTemplateCommandInterface $command
     * @return ReportTemplateInterface
     */
    public function publish(PublishReportTemplateCommandInterface $command): ReportTemplateInterface;
}
