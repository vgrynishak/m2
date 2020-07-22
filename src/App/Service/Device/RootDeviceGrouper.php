<?php

namespace App\App\Service\Device;

use App\App\Factory\Group\GroupFactoryInterface;
use App\App\Service\Exception\RootDeviceInvalidLevelException;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Device\Group;
use App\Core\Model\Paragraph\ParagraphFilter;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;

class RootDeviceGrouper implements RootDeviceGrouperInterface
{
    /** @var GroupFactoryInterface */
    private $groupFactory;

    /**
     * RootDeviceGrouper constructor.
     * @param GroupFactoryInterface $groupFactory
     */
    public function __construct(GroupFactoryInterface $groupFactory)
    {
        $this->groupFactory = $groupFactory;
    }

    /**
     * @param DeviceInterface $targetDevice
     * @param CollectionInterface $arrayDevice
     * @return CollectionInterface
     * @throws RootDeviceInvalidLevelException
     * @throws \Exception
     */
    public function group(DeviceInterface $targetDevice, CollectionInterface $arrayDevice): CollectionInterface
    {
        $rootDeviceRelatedToInspected = $this->getKeyRelatedDevices($targetDevice, $arrayDevice);

        $groupRelated = $this->groupFactory->make(
            Group::GROUP_RELATED_TO_INSPECTED_DEVICE,
            ParagraphFilter::FILTER_INSPECTION
        );
        $groupRelated->setDevices(new Set([$rootDeviceRelatedToInspected]));

        $arrayDevice->remove($rootDeviceRelatedToInspected); //every on site

        $groupEveryOnSite = $this->groupFactory->make(
            Group::GROUP_EVERY_ON_SITE_DEVICE,
            ParagraphFilter::FILTER_ON_SITE
        );
        $groupEveryOnSite->setDevices($arrayDevice);

        return new Set([
            $groupRelated,
            $groupEveryOnSite
        ]);
    }

    /**
     * @param DeviceInterface $device
     * @param CollectionInterface $arrayDevice
     * @return DeviceInterface|null
     * @throws RootDeviceInvalidLevelException
     */
    private function getKeyRelatedDevices(DeviceInterface $device, CollectionInterface $arrayDevice): ?DeviceInterface
    {
        $deviceId = $device->getAlias();

        /** @var DeviceInterface $root */
        foreach ($arrayDevice as $root) {
            if ($root->getAlias() === $deviceId ||
                ($root->getChildren() && $this->isExistChildren($deviceId, $root->getChildren()))) {
                return $root;
            }
        }

        return null;
    }

    /**
     * @param string $deviceId
     * @param CollectionInterface $arrayDevice
     * @return bool
     * @throws RootDeviceInvalidLevelException
     */
    private function isExistChildren(string  $deviceId, CollectionInterface $arrayDevice): bool
    {
        /** @var Device $root */
        foreach ($arrayDevice as $root) {
            if ($root->getLevel() > self::MAX_DEPTH) {
                throw new RootDeviceInvalidLevelException('too high level a maximum is allowed '.self::MAX_DEPTH);
            }

            if ($root->getAlias() === $deviceId) {
                return true;
            }

            if ($root->getChildren() && $root->getChildren()->count() &&
                $this->isExistChildren($deviceId, $root->getChildren())) {
                return true;
            }
        }

        return false;
    }
}
