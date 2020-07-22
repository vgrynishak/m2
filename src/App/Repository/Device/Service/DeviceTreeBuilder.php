<?php

namespace App\App\Repository\Device\Service;

use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\App\Repository\Exception\NonDevices;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use App\Core\Model\Device\Device;
use PhpCollection\Set;

class DeviceTreeBuilder implements DeviceTreeBuilderInterface
{
    private const PERMITTED_MAX_LEVEL = 2;
    public const DEVICE_LIST_IS_EMPTY = "Device list is empty";

    /** @var DoctrineEntityDeviceMapperInterface  */
    private $mapper;
    /** @var array  */
    private $deviceTreeArray = [];
    /** @var array  */
    private $deviceTreeCacheArray = [];
    /** @var int  */
    private $maxLevel = 0;

    /**
     * DeviceTreeBuilder constructor.
     * @param DoctrineEntityDeviceMapperInterface $mapper
     */
    public function __construct(DoctrineEntityDeviceMapperInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->deviceTreeArray = [];
        $this->deviceTreeCacheArray = [];
        $this->maxLevel = 0;
    }

    /**
     * @param $deviceORMArray
     * @return mixed|Set
     * @throws ChildrenDeviceInvalidLevelException
     * @throws NonDevices
     */
    public function build($deviceORMArray)
    {
        if (empty($deviceORMArray)) {
            throw new NonDevices(self::DEVICE_LIST_IS_EMPTY);
        }
        /** @var DeviceEntity $deviceORM */
        foreach ($deviceORMArray as $deviceORM) {
            $this->deviceTreeCacheArray[$deviceORM->getId()] = $this->mapper->map($deviceORM);
            if ($deviceORM->getLevel() > $this->maxLevel) {
                $this->maxLevel = $deviceORM->getLevel();
            }
            if ($this->maxLevel > self::PERMITTED_MAX_LEVEL) {
                throw new ChildrenDeviceInvalidLevelException(
                    "Too high level a maximum is allowed ".self::PERMITTED_MAX_LEVEL
                );
            }
        }

        for ($i = $this->maxLevel; $i >= 1; $i--) {
            $this->findParentAndReplaceSubdevice($i);
        }

        foreach ($this->deviceTreeCacheArray as $deviceTreeItem) {
            $this->deviceTreeArray[] = $deviceTreeItem;
        }

        return new Set($this->deviceTreeArray);
    }


    /**
     * @param $subDeviceLevel
     */
    private function findParentAndReplaceSubdevice($subDeviceLevel)
    {
        /**
         * @var  $key
         * @var  Device $deviceTreeItem
         */
        foreach ($this->deviceTreeCacheArray as $key => $deviceTreeItem) {
            $parentId = ($deviceTreeItem->getParentId()) ? $deviceTreeItem->getParentId()->getValue() : null;
            if ($deviceTreeItem->getLevel() == $subDeviceLevel and $parentId) {
                $this->updateParentRelation(
                    $this->deviceTreeCacheArray[$parentId],
                    $deviceTreeItem
                );
                unset($this->deviceTreeCacheArray[$key]);
            }
        }
    }

    /**
     * @param Device $parentDevice
     * @param Device $childDevice
     */
    private function updateParentRelation(Device $parentDevice, Device $childDevice)
    {
        $childrenCollection = $parentDevice->getChildren();
        if (!$childrenCollection) {
            $childrenCollection = new Set([]);
        }
        $childrenCollection->add($childDevice);
        $parentDevice->setChildren($childrenCollection);
    }
}
