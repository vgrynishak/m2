<?php

namespace App\Infrastructure\Parser\Device;

use App\App\Query\Device\FindByChildrenDeviceQuery;
use App\App\Query\Device\FindByChildrenDeviceQueryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\GroupId;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use \Exception;

class ChildrenDeviceParser implements ChildrenDeviceParserInterface
{
    /**
     * @param Request $request
     * @return FindByChildrenDeviceQueryInterface
     * @throws FailGetListDevice
     * @throws InvalidArgumentException
     */
    public function parse(Request $request): FindByChildrenDeviceQueryInterface
    {
        try {
            /** @var DeviceId $deviceId */
            $deviceId = $request->get('deviceId');

            if (!$deviceId instanceof DeviceId) {
                throw new InvalidArgumentException('Argument deviceId is required');
            }

            $body = $request->request->all();

            if (!array_key_exists('getListForChildrenParagraph', $body)) {
                throw new InvalidArgumentException('Invalid root key');
            }

            $data = $body['getListForChildrenParagraph'];

            if (!array_key_exists('groupId', $data)) {
                throw new InvalidArgumentException('groupId is required field');
            }

            $findByChildrenDeviceQuery = new FindByChildrenDeviceQuery($deviceId);
            $findByChildrenDeviceQuery->setGroupId(new GroupId($data['groupId']));

            return $findByChildrenDeviceQuery;
        } catch (Exception $exception) {
            throw new FailGetListDevice($exception->getMessage());
        }
    }
}
