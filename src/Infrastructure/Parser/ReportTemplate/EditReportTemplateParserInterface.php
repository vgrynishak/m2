<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface EditReportTemplateParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return EditReportTemplateCommandInterface
     */
    public function parse(Request $request): EditReportTemplateCommandInterface;
}
