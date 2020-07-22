<?php

namespace App\Infrastructure\Adapter\Group;

use App\Core\Model\Device\Device;
use App\Core\Model\Device\Group;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use PhpCollection\CollectionInterface;
use App\Infrastructure\Adapter\DTO\Group\Full as FullGroupDto;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as FullFilterDto;
use App\Infrastructure\Adapter\DTO\Device\ShortForGroup as FullDeviceDto;

class Full
{
    /**
     * @param Group $group
     * @return FullGroupDto
     */
    public static function adapt(Group $group): FullGroupDto
    {
        /** @var FullGroupDto $fullParagraph */
        $fullGroup = new FullGroupDto(
            $group->getId()->getValue(),
            $group->getName()
        );

        if ($group->getFilter()) {
            /** @var FullFilterDto $filter */
            $filter = new FullFilterDto($group->getFilter()->getId()->getValue(), $group->getFilter()->getName());
            $fullGroup->setFilter($filter);
        }

        /** @var array $devicesDto */
        $devicesDto = [];
        self::getDevices($group->getDevices(), $devicesDto);

        $fullGroup->setDevices($devicesDto);

        return $fullGroup;
    }

    /**
     * @param CollectionInterface $groupCollection
     * @return array
     */
    public static function adaptCollection(CollectionInterface $groupCollection): array
    {
        /** @var  FullGroupDto[] $resultGroups */
        $resultGroups = [];

        foreach ($groupCollection as $group) {
            $resultGroups[] = self::adapt($group);
        }

        return ['getDeviceGroupsResponse' => $resultGroups];
    }

    /**
     * @param CollectionInterface $devices
     * @param array $devicesDto
     */
    public static function getDevices(CollectionInterface $devices, array &$devicesDto = [])
    {
        /** @var Device $device */
        foreach ($devices as $device) {
            $devicesDto[] = new FullDeviceDto(
                $device->getId()->getValue(),
                $device->getName(),
                $device->getLevel()
            );

            if ($device->getChildren() and $device->getChildren()->count()) {
                self::getDevices($device->getChildren(), $devicesDto);
            }
        }
    }
}
