<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface DeleteReportTemplateParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return DeleteReportTemplateCommandInterface
     */
    public function parse(Request $request): DeleteReportTemplateCommandInterface;
}
