<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface EditReportTemplateValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param EditReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(EditReportTemplateCommandInterface $command): bool;
}
