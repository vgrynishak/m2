<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface ChangeSectionPositionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return ChangeSectionPositionCommandInterface
     */
    public function parse(Request $request): ChangeSectionPositionCommandInterface;
}
