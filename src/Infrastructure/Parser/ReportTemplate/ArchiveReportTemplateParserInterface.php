<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface ArchiveReportTemplateParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return ArchiveReportTemplateCommandInterface
     */
    public function parse(Request $request): ArchiveReportTemplateCommandInterface;
}
