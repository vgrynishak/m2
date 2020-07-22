<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface ArchiveReportTemplateValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param ArchiveReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(ArchiveReportTemplateCommandInterface $command): bool;
}
