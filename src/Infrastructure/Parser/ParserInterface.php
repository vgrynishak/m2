<?php

namespace App\Infrastructure\Parser;

use Symfony\Component\HttpFoundation\Request;

interface ParserInterface
{
    public function parse(Request $request);
}
