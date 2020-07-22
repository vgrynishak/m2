<?php

namespace App\Infrastructure\Parser\Device;

use App\App\Query\Device\FindByRootDeviceQuery;
use App\App\Query\Device\FindByRootDeviceQueryInterface;
use App\Core\Model\Device\DeviceId;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use InvalidArgumentException;
use \Exception;
use Symfony\Component\HttpFoundation\Request;

class RootDeviceParser implements RootDeviceParserInterface
{
    /**
     * @param Request $request
     * @return FindByRootDeviceQueryInterface
     * @throws FailGetListDevice
     * @throws InvalidArgumentException
     */
    public function parse(Request $request): FindByRootDeviceQueryInterface
    {
        try {
            /** @var DeviceId $deviceId */
            $deviceId = $request->get('deviceId');

            if (!$deviceId instanceof DeviceId) {
                throw new InvalidArgumentException('Argument deviceId is required');
            }

            return new FindByRootDeviceQuery($deviceId);
        } catch (Exception $exception) {
            throw new FailGetListDevice($exception->getMessage());
        }
    }
}
