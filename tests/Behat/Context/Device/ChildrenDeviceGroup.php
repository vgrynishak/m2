<?php

namespace App\Tests\Behat\Context\Device;

use App\App\Doctrine\Entity\Device;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\App\Service\Device\ChildrenDeviceGrouper;
use App\App\Service\Device\RootDeviceGrouperInterface;
use App\App\Service\Exception\ChildrenDeviceGrouperException;
use App\App\Service\Exception\ChildrenDeviceInvalidLevelException;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Device\Group;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\Exception\InvalidGroupIdException;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use PHPUnit\Framework\Assert;
use ReflectionException;

class ChildrenDeviceGroup implements Context
{
    public const ALIAS = 'dry_valve_system';
    public const ALIAS_WITH_ERROR_LEVEL = 'standpipe_system';

    /** @var CollectionInterface */
    private $treeDevices;
    /** @var CollectionInterface */
    private $relatedDevices;
    /** @var DeviceInterface */
    private $device;
    /** @var RootDeviceGrouperInterface */
    private $deviceGrouper;
    /** @var DeviceRepository */
    private $deviceEntity;
    /** @var CollectionInterface */
    private $groups;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $deviceMapper;

    /**
     * ChildrenDeviceGroup constructor.
     * @param ChildrenDeviceGrouper $deviceGrouper
     * @param DeviceRepository $deviceEntity
     * @param DoctrineEntityDeviceMapperInterface $deviceMapper
     */
    public function __construct(
        ChildrenDeviceGrouper $deviceGrouper,
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
     * @throws ReflectionException
     */
    private function setIncorectLevel(DeviceInterface $device)
    {
         $reflectionClass = new \ReflectionClass($device);
         $property = $reflectionClass->getProperty('level');
         $property->setAccessible(true);
         $property->setValue($device, 3);
    }

    private function prepareDevices(): void
    {
        $fireSprinklerSystem    = $this->getDeviceModelByAlias('fire_sprinkler_system');
        $dryValueSystem         = $this->getDeviceModelByAlias('dry_valve_system');
        $airCompressor          = $this->getDeviceModelByAlias('air_compressor');
        $standPipeSystem        = $this->getDeviceModelByAlias('standpipe_system');
        $firePump               = $this->getDeviceModelByAlias('fire_pump');
        $lowPoint               = $this->getDeviceModelByAlias('low_point');
        $foamSystem             = $this->getDeviceModelByAlias('foam_system');
        $fireDoor               = $this->getDeviceModelByAlias('fire_door');

        $this->setIncorectLevel($standPipeSystem);
        $this->setIncorectLevel($firePump);

        $childrenThirdLevel = new Set([
            $standPipeSystem,
            $firePump
        ]);

        $airCompressor->setChildren($childrenThirdLevel);
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

        $this->relatedDevices = $childrenSecondLevel;

        $this->treeDevices = new Set([
            $fireSprinklerSystem,
            $fireDoor
        ]);
    }

    /**
     * @Given Device with id and array all devices
     */
    public function deviceWithIdAndArrayAllDevices(): void
    {
        /** @var DeviceInterface $deviceModel */
        $this->device    = $this->getDeviceModelByAlias(self::ALIAS);
    }

    /**
     * @Given Device with id and array with too high level devices
     */
    public function deviceWithIdAndArrayWithTooHighLevelDevices(): void
    {
        /** @var DeviceInterface $deviceModel */
        $this->device    = $this->getDeviceModelByAlias(self::ALIAS_WITH_ERROR_LEVEL);
    }


    /**
     * @When I call method group
     */
    public function iCallMethodGroup(): void
    {
        try {
            $this->prepareDevices();
            $this->groups = $this->deviceGrouper->group($this->device, $this->treeDevices, new GroupId(Group::GROUP_RELATED_TO_INSPECTED_DEVICE));
        } catch (
            ChildrenDeviceGrouperException |
            InvalidGroupIdException |
            ChildrenDeviceInvalidLevelException$exception) {
            $this->groups = $exception;
        }
    }

    /**
     * @Then I should have ChildrenDeviceInvalidLevelException
     */
    public function iShouldHaveChildrenDeviceInvalidLevelException(): void
    {
        Assert::assertInstanceOf(ChildrenDeviceInvalidLevelException::class, $this->groups);
    }

    /**
     * @Then I should have right array group
     * @throws \Exception
     */
    public function iShouldGetRightArrayGroup(): void
    {
        if ($this->groups instanceof \Exception) {
            throw new \RuntimeException($this->groups->getMessage());
        }

        if ($this->groups->count() !== 1) {
            throw new \RuntimeException('count elements does not equal one');
        }

        /** @var Group $group */
        foreach ($this->groups->getiterator() as $group) {
            if ($group->getId()->getValue() !== Group::GROUP_RELATED_TO_INSPECTED_DEVICE)
                throw new \RuntimeException('group id does not correct');

            if ($this->relatedDevices->all() !== $group->getDevices()->all()) {
                throw new \RuntimeException('incorrect devices');
            }
        }
    }
}
