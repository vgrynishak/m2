<?php

namespace App\Infrastructure\Parser\Device;

use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface ChildrenDeviceParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return FindByChildrenDeviceQueryInterface
     * @throws FailGetListDevice
     * @throws \InvalidArgumentException
     */
    public function parse(Request $request) : FindByChildrenDeviceQueryInterface;
}
