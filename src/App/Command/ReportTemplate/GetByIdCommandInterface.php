<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\ReportTemplate\ReportTemplateId;

interface GetByIdCommandInterface
{
    public function getId(): ReportTemplateId;
}
