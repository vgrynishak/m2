<?php

namespace App\Infrastructure\Parser\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateDeviceInformationItem;
use App\Infrastructure\Parser\ParserInterface;
use Symfony\Component\HttpFoundation\Request;

interface UpdateDeviceInformationItemParserInterface extends ParserInterface
{
    /**
     * @param Request $request
     * @return UpdateDeviceInformationItemCommandInterface
     * @throws FailUpdateDeviceInformationItem
     */
    public function parse(Request $request): UpdateDeviceInformationItemCommandInterface;
}
