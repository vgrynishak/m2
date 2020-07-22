<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\CreateSectionCommandInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Parser\ParserInterface;

interface CreateSectionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreateSectionCommandInterface
     */
    public function parse(Request $request): CreateSectionCommandInterface;
}
