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
use App\Core\Model\Exception\InvalidGroupIdException;
use Behat\Behat\Context\Context;
use http\Exception\RuntimeException;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use PhpCollection\SetInterface;
use PHPUnit\Exception;
use PHPUnit\Framework\Assert;

class RootDeviceGroup implements Context
{
    public const ALIAS = 'dry_valve_system';
    public const ALIAS_WITH_ERROR_LEVEL = 'standpipe_system';

    /** @var CollectionInterface */
    private $treeDevices;
    /** @var CollectionInterface */
    private $relatedDevices;
    /** @var CollectionInterface */
    protected $everyOnSite;
    /** @var DeviceInterface */
    private $device;
    /** @var RootDeviceGrouperInterface */
    private $deviceGrouper;
    /** @var DeviceRepository */
    private $deviceEntity;
    /** @var SetInterface | Exception */
    private $groups;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $deviceMapper;

    /**
     * RootDeviceGroup constructor.
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

    private function setIncorrectLevel(DeviceInterface $device): void
    {
        try {
            $reflectionClass = new \ReflectionClass($device);
        } catch (\ReflectionException $e) {
            throw new RuntimeException($e->getMessage());
        }
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

        $this->setIncorrectLevel($standPipeSystem);
        $this->setIncorrectLevel($firePump);

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

        $this->relatedDevices = new Set([
            $fireSprinklerSystem
        ]);

        $this->everyOnSite = new Set([
            $fireDoor
        ]);

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
    public function deviceWithIdAndArrayWithTooHighLevelDevices()
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
            $this->groups = $this->deviceGrouper->group($this->device, $this->treeDevices);
        } catch (
            RootDeviceGrouperException |
            InvalidGroupIdException |
            RootDeviceInvalidLevelException $exception) {
            $this->groups = $exception;
        }
    }

    /**
     * @Then I should have RootDeviceInvalidLevelException
     */
    public function iShouldHaveRootDeviceInvalidLevelException(): void
    {
        Assert::assertInstanceOf(RootDeviceInvalidLevelException::class, $this->groups);
    }

    /**
     * @Then I should have right array group
     *
     * @return void
     * @throws \Exception
     */
    public function iShouldHaveRightArrayGroup(): void
    {
        if (!$this->groups instanceof CollectionInterface) {
            throw new \RuntimeException($this->groups->getMessage() ?? 'error');
        }

        if ($this->groups->count() !== 2) {
            throw new \RuntimeException('count elements does not equal two');
        }

        /** @var Group $group */
        foreach ($this->groups->getIterator() as $group){
            if ($group->getId()->getValue() === Group::GROUP_RELATED_TO_INSPECTED_DEVICE) {
                $rightDevices = $this->relatedDevices;
            } elseif ($group->getId()->getValue() === Group::GROUP_EVERY_ON_SITE_DEVICE) {
                $rightDevices = $this->everyOnSite;
            } else {
                throw new \RuntimeException('group id does not correct');
            }

            if ($rightDevices->all() !== $group->getDevices()->all()) {
                throw new \RuntimeException('incorrect devices');
            }
        }
    }
}
