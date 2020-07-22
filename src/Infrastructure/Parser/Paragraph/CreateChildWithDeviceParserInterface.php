<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateChildWithDeviceParserInterface extends ParserInterface
{
    public function parse(Request $request): CreateChildWithDeviceCommandInterface;
}
