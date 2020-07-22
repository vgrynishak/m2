<?php

namespace App\App\Service\Device;

use App\App\Factory\Group\GroupFactoryInterface;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Device\GroupId;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class ChildrenDeviceGrouper implements ChildrenDeviceGrouperInterface
{
    /** @var GroupFactoryInterface */
    private $groupFactory;

    /**
     * ChildrenDeviceGrouper constructor.
     * @param GroupFactoryInterface $groupFactory
     */
    public function __construct(GroupFactoryInterface $groupFactory)
    {
        $this->groupFactory = $groupFactory;
    }

    /**
     * @param DeviceInterface $targetDevice
     * @param CollectionInterface $arrayDevice
     * @param GroupId $groupId
     * @return CollectionInterface
     * @throws ChildrenDeviceInvalidLevelException
     */
    public function group(DeviceInterface $targetDevice, CollectionInterface $arrayDevice, GroupId $groupId)
    : CollectionInterface
    {
        $children = $this->getKeyRelatedDevices($targetDevice, $arrayDevice);

        $groupRelated = $this->groupFactory->make($groupId->getValue());
        $groupRelated->setDevices($children);

        return new Set([$groupRelated]);
    }

    /**
     * @param DeviceInterface $device
     * @param CollectionInterface $arrayDevice
     * @return CollectionInterface|null
     * @throws ChildrenDeviceInvalidLevelException
     */
    private function getKeyRelatedDevices(DeviceInterface $device, CollectionInterface $arrayDevice)
    : ?CollectionInterface
    {
        $deviceId = $device->getAlias();
        /** @var DeviceInterface $root */
        foreach ($arrayDevice->getIterator() as $root) {
            if ($root->getLevel() && $root->getLevel() > self::MAX_DEPTH) {
                throw new ChildrenDeviceInvalidLevelException(
                    'too high level a maximum is allowed '.self::MAX_DEPTH
                );
            }

            if ($root->getAlias() && $root->getAlias() === $deviceId) {
                return $root->getChildren() ?? new Set([]);
            }

            if ($root->getChildren() &&
                is_object($devices = $this->getKeyRelatedDevices($device, $root->getChildren()))) {
                return $devices;
            }
        }
        return null;
    }
}
