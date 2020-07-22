<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface ChangeParagraphPositionParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return ChangeParagraphPositionCommandInterface
     */
    public function parse(Request $request): ChangeParagraphPositionCommandInterface;
}
