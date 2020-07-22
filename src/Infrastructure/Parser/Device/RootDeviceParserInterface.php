<?php

namespace App\Infrastructure\Parser\Device;

use App\App\Query\Device\FindByRootDeviceQueryInterface;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface RootDeviceParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return FindByRootDeviceQueryInterface
     * @throws FailGetListDevice
     * @throws \InvalidArgumentException
     */
    public function parse(Request $request) : FindByRootDeviceQueryInterface;
}
