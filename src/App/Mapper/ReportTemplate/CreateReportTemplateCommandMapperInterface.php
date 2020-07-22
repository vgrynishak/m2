<?php

namespace App\App\Mapper\ReportTemplate;

use App\App\Component\Message\MessageInterface;
use App\App\Mapper\MapperInterface;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;

interface CreateReportTemplateCommandMapperInterface extends MapperInterface
{
    public function map(MessageInterface $command): ReportTemplateInterface;
}
