<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface DeleteParagraphParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return DeleteParagraphCommandInterface
     */
    public function parse(Request $request): DeleteParagraphCommandInterface;
}
