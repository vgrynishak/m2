<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface PublishReportTemplateParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return PublishReportTemplateCommandInterface
     */
    public function parse(Request $request): PublishReportTemplateCommandInterface;
}
