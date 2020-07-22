<?php

namespace App\Infrastructure\Parser\Item\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommand;
use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdateDeviceInformationItem;
use Symfony\Component\HttpFoundation\Request;

class UpdateDeviceInformationItemParser extends BaseDeviceInformationItemParser implements
    UpdateDeviceInformationItemParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(Request $request): UpdateDeviceInformationItemCommandInterface
    {
        try {
            $body = $request->request->all();

            if (!array_key_exists('updateDeviceInformationItem', $body)) {
                throw new \InvalidArgumentException('Invalid root key');
            }

            return $this->parseRequestAndFillCommand(
                $body['updateDeviceInformationItem'],
                new UpdateDeviceInformationItemCommand()
            );
        } catch (\Exception $exception) {
            throw new FailUpdateDeviceInformationItem('Bad request. ' . $exception->getMessage());
        }
    }
}
