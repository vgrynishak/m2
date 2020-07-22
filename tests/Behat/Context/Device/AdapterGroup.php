<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Doctrine\Entity\Device;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\App\Service\Device\RootDeviceGrouperInterface;
use App\App\Service\Device\RootDeviceGrouper;
use App\App\Service\Exception\RootDeviceGrouperException;
use App\App\Service\Exception\RootDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Device\Group;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Infrastructure\Adapter\Group\Full as GroupAdapter;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use App\Infrastructure\Adapter\DTO\Group\Full as FullGroupDto;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as FullFilterDto;
use App\Infrastructure\Adapter\DTO\Device\ShortForGroup as FullDeviceDto;
use http\Exception\RuntimeException;
use App\Core\Model\Paragraph\ParagraphFilter;

class AdapterGroup implements Context
{
    public const ALIAS = 'dry_valve_system';

    /** @var CollectionInterface */
    private $treeDevices;
    /** @var RootDeviceGrouperInterface */
    private $deviceGrouper;
    /** @var DeviceRepository */
    private $deviceEntity;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $deviceMapper;
    /** @var CollectionInterface */
    private $groups;
    /** @var array */
    private $adaptGroup;
    /** @var array */
    private $correctArrayAfterAdept;

    /**
     * AdapterGroup constructor.
     * @param RootDeviceGrouper $deviceGrouper
     * @param DeviceRepository $deviceEntity
     * @param DoctrineEntityDeviceMapperInterface $deviceMapper
     */
    public function __construct(
        RootDeviceGrouper $deviceGrouper,
        DeviceRepository $deviceEntity,
        DoctrineEntityDeviceMapperInterface $deviceMapper
    ) {
        $this->deviceGrouper = $deviceGrouper;
        $this->deviceEntity = $deviceEntity;
        $this->deviceMapper = $deviceMapper;
    }

    /**
     * @param string $alias
     * @return DeviceInterface|null
     */
    private function getDeviceModelByAlias(string $alias): ?DeviceInterface
    {
        /** @var Device $deviceEntity */
        $deviceEntity   = $this->deviceEntity->findOneBy([
            'alias' => $alias
        ]);

        try {
            return $this->deviceMapper->map($deviceEntity);
        } catch (InvalidDeviceIdException | InvalidDivisionIdException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @param DeviceInterface $device
     * @return FullDeviceDto
     */
    private function getDeviceDto(DeviceInterface $device): FullDeviceDto
    {
        return new FullDeviceDto(
            $device->getId()->getValue(),
            $device->getName(),
            $device->getLevel()
        );
    }

    /**
     * @param $id
     * @param $name
     * @param FullFilterDto $filter
     * @param array $devices
     * @return FullGroupDto
     */
    private function getGroupDto($id, $name, FullFilterDto $filter, array $devices): FullGroupDto
    {
        $group  = new FullGroupDto($id, $name);

        $group->setFilter($filter);
        $group->setDevices($devices);

        return $group;
    }

    private function prepareDevicesAndAdeptArray(): void
    {
        $fireSprinklerSystem    = $this->getDeviceModelByAlias('fire_sprinkler_system');
        $dryValueSystem         = $this->getDeviceModelByAlias('dry_valve_system');
        $airCompressor          = $this->getDeviceModelByAlias('air_compressor');
        $lowPoint               = $this->getDeviceModelByAlias('low_point');
        $foamSystem             = $this->getDeviceModelByAlias('foam_system');
        $fireDoor               = $this->getDeviceModelByAlias('fire_door');

        $childrenSecondLevel = new Set([
            $lowPoint,
            $airCompressor
        ]);

        $dryValueSystem->setChildren($childrenSecondLevel);
        $childrenFirstLevel = new Set([
            $dryValueSystem,
            $foamSystem
        ]);

        $fireSprinklerSystem->setChildren($childrenFirstLevel);

        $this->treeDevices = new Set([
            $fireSprinklerSystem,
            $fireDoor
        ]);

        $relatedGroupDevices = [
            $this->getDeviceDto($fireSprinklerSystem),
            $this->getDeviceDto($dryValueSystem),
            $this->getDeviceDto($lowPoint),
            $this->getDeviceDto($airCompressor),
            $this->getDeviceDto($foamSystem),
        ];


        $everyOnSiteGroupDevices = [
            $this->getDeviceDto($fireDoor),
        ];

        $this->correctArrayAfterAdept = ['getDeviceGroupsResponse' => [
            $this->getGroupDto(
                Group::GROUP_RELATED_TO_INSPECTED_DEVICE,
                'Related to inspected device',
                new FullFilterDto(ParagraphFilter::FILTER_INSPECTION, 'Related to an inspected device'),
                $relatedGroupDevices
            ),
            $this->getGroupDto(
                Group::GROUP_EVERY_ON_SITE_DEVICE,
                'Every On site',
                new FullFilterDto(ParagraphFilter::FILTER_ON_SITE, 'Every on site'),
                $everyOnSiteGroupDevices
            )
        ]];
    }


    /**
     * @Given Group Collection with filter and devices
     */
    public function groupCollectionWithFilterAndDevices()
    {
        $device    = $this->getDeviceModelByAlias(self::ALIAS);
        $this->prepareDevicesAndAdeptArray();

        try {
            $this->groups = $this->deviceGrouper->group($device, $this->treeDevices);
        } catch (RootDeviceGrouperException | RootDeviceInvalidLevelException |  InvalidParagraphFilterIdException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @When I call static method adaptCollection
     */
    public function iCallStaticMethodAdaptcollection()
    {
        $this->adaptGroup = GroupAdapter::adaptCollection($this->groups);
    }

    /**
     * @Then I should have right array group
     */
    public function iShouldHaveRightArrayGroup()
    {
        if (serialize($this->adaptGroup) !==  serialize($this->correctArrayAfterAdept)) {
           throw new \RuntimeException('incorrect array after adept');
        }

        return true;
    }
}
