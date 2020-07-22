<?php

namespace App\Infrastructure\Parser\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateDeviceInformationItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateDeviceInformationItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return CreateDeviceInformationItemCommandInterface
     * @throws FailCreateDeviceInformationItem
     */
    public function parse(Request $request): CreateDeviceInformationItemCommandInterface;
}
