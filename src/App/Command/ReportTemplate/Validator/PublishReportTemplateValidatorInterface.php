<?php

namespace App\App\Command\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Component\Validator\ErrorManagerInterface as ValidatorErrorManagerInterface;

interface PublishReportTemplateValidatorInterface extends ValidatorErrorManagerInterface
{
    /**
     * @param PublishReportTemplateCommandInterface $command
     * @return bool
     */
    public function validate(PublishReportTemplateCommandInterface $command): bool;
}
