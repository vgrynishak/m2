<?php

namespace App\Tests\Behat\Context\Device\Doctrine\Mapper;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Repository\DeviceRepository;
use App\App\Mapper\Device\DoctrineEntityDeviceMapperInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use App\Core\Model\User\UserInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class DeviceDoctrineEntityMapper implements Context
{
    /** @var DeviceEntity */
    private $deviceEntity;
    /** @var DeviceInterface */
    private $device;
    /** @var DoctrineEntityDeviceMapperInterface */
    private $mapper;
    /** @var DeviceRepository */
    private $deviceRepository;

    /**
     * DeviceDoctrineEntityMapper constructor.
     * @param DoctrineEntityDeviceMapperInterface $mapper
     * @param DeviceRepository $deviceRepository
     */
    public function __construct(DoctrineEntityDeviceMapperInterface $mapper, DeviceRepository $deviceRepository)
    {
        $this->mapper = $mapper;
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @Given I’m find and set correct DeviceEntity
     */
    public function imFindAndSetCorrectDeviceentity()
    {
        $this->deviceEntity = $this->deviceRepository->find('081a5bbd-d5fe-4838-867e-5b7e3af7bf91');
    }

    /**
     * @When I call Method map
     */
    public function iCallMethodMap()
    {
        $this->device = $this->mapper->map($this->deviceEntity);
    }

    /**
     * @Then I should get Device which Implements DeviceInterface
     */
    public function iShouldGetDeviceWhichImplementsDeviceinterface()
    {
        Assert::assertTrue($this->device instanceof DeviceInterface);
        Assert::assertTrue($this->device->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->device->getUpdatedAt() instanceof DateTime);
        if ($this->device->getParentId()) {
            Assert::assertTrue($this->device->getParentId() instanceof DeviceId);
        }
        Assert::assertTrue($this->device->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->device->getModifiedBy() instanceof UserInterface);
        if ($this->device->getDynamicFields()) {
            /** @var DeviceDynamicFieldInterface $dynamicField */
            foreach ($this->device->getDynamicFields() as $dynamicField) {
                Assert::assertTrue($dynamicField instanceof DeviceDynamicFieldInterface);
            }
        }
    }
}
