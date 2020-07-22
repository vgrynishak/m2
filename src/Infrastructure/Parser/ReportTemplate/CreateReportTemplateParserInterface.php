<?php


namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateReportTemplateParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreateReportTemplateCommandInterface
     */
    public function parse(Request $request): CreateReportTemplateCommandInterface;
}
