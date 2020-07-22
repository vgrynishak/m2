<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\EditSectionCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface EditSectionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return EditSectionCommandInterface
     */
    public function parse(Request $request): EditSectionCommandInterface;
}
