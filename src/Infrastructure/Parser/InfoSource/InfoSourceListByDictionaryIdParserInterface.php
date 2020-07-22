<?php

namespace App\Infrastructure\Parser\InfoSource;

use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface InfoSourceListByDictionaryIdParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return InfoSourceListByDictionaryIdQueryInterface
     */
    public function parse(Request $request): InfoSourceListByDictionaryIdQueryInterface;
}
