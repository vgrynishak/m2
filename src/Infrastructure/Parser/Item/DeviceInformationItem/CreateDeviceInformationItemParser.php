<?php

namespace App\Infrastructure\Parser\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommand;
use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateDeviceInformationItem;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateDeviceInformationItemParser extends BaseDeviceInformationItemParser implements
    CreateDeviceInformationItemParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): CreateDeviceInformationItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('createDeviceInformationItem', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand(
                $body['createDeviceInformationItem'],
                new CreateDeviceInformationItemCommand()
            );
        } catch (\Exception $exception) {
            throw new FailCreateDeviceInformationItem('Bad request. ' . $exception->getMessage());
        }
    }
}
