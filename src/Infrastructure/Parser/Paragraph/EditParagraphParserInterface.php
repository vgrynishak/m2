<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface EditParagraphParserInterface extends ParserInterface
{
    public function parse(Request $request): EditParagraphCommandInterface ;
}
