<?php

namespace App\Infrastructure\Parser\Item\ChangeItemPosition;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\Infrastructure\Exception\Item\FailChangeItemPosition;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface ChangeItemPositionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return ChangeItemPositionCommandInterface
     * @throws FailChangeItemPosition
     */
    public function parse(Request $request): ChangeItemPositionCommandInterface;
}
