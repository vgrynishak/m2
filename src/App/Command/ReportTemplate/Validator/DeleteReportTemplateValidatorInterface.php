<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface DeleteReportTemplateValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param DeleteReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(DeleteReportTemplateCommandInterface $command): bool;
}
