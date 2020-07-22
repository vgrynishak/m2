<?php

namespace App\Infrastructure\Parser\Paragraph;

use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateRootWithoutDeviceParserInterface extends ParserInterface
{
    public function parse(Request $request): CreateRootWithoutDeviceCommandInterface;
}
