<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateRootWithDeviceParserInterface extends ParserInterface
{
    public function parse(Request $request): CreateRootWithDeviceCommandInterface;
}
