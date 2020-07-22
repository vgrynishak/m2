<?php

namespace App\Infrastructure\Parser\Section;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface DeleteSectionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return DeleteSectionCommandInterface
     */
    public function parse(Request $request): DeleteSectionCommandInterface;
}
