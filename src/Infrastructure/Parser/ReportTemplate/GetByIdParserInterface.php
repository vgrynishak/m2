<?php

namespace App\Infrastructure\Parser\ReportTemplate;

use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface GetByIdParserInterface extends ParserInterface
{
    public function parse(Request $request): GetByIdCommandInterface;
}
