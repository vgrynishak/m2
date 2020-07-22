<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface CreateReportTemplateValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param CreateReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(CreateReportTemplateCommandInterface $command): bool;
}
