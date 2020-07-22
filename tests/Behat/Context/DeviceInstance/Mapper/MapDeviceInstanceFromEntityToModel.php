<?php

namespace App\Tests\Behat\Context\DeviceInstance\Mapper;

use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Repository\DeviceInstanceRepository;
use App\App\Mapper\DeviceInstance\DoctrineEntityDeviceInstanceMapperInterface;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class MapDeviceInstanceFromEntityToModel implements Context
{
    /** @var DeviceInstanceRepository */
    private $deviceInstanceRepository;
    /** @var DoctrineEntityDeviceInstanceMapperInterface */
    private $doctrineEntityDeviceInstanceMapper;
    /** @var DeviceInstanceEntity */
    private $deviceInstanceEntity;
    /** @var DeviceInstanceInterface */
    private $deviceInstance;

    /**
     * MapDeviceInstanceFromEntityToModel constructor.
     * @param DeviceInstanceRepository $deviceInstanceRepository
     * @param DoctrineEntityDeviceInstanceMapperInterface $doctrineEntityDeviceInstanceMapper
     */
    public function __construct(
        DeviceInstanceRepository $deviceInstanceRepository,
        DoctrineEntityDeviceInstanceMapperInterface $doctrineEntityDeviceInstanceMapper
    ) {
        $this->deviceInstanceRepository = $deviceInstanceRepository;
        $this->doctrineEntityDeviceInstanceMapper = $doctrineEntityDeviceInstanceMapper;
    }

    /**
     * @Given I’m find and set correct DeviceInstanceEntity
     */
    public function imFindAndSetCorrectDeviceinstanceentity()
    {
        $this->deviceInstanceEntity = $this->deviceInstanceRepository->find('d6306c0a-3b9c-11ea-b77f-2e728ce88125');
    }

    /**
     * @When I call Method map
     */
    public function iCallMethodMap()
    {
        $this->deviceInstance = $this->doctrineEntityDeviceInstanceMapper->map($this->deviceInstanceEntity);
    }

    /**
     * @Then I should get DeviceInstance that Implements DeviceInstanceInterface
     */
    public function iShouldGetDeviceinstanceThatImplementsDeviceinstanceinterface()
    {
        Assert::assertTrue($this->deviceInstance instanceof DeviceInstanceInterface);
        Assert::assertTrue($this->deviceInstance->getDevice() instanceof DeviceInterface);
        Assert::assertTrue($this->deviceInstance->getFacilityId() instanceof FacilityId);
        Assert::assertTrue($this->deviceInstance->getId() instanceof DeviceInstanceId);
        Assert::assertTrue($this->deviceInstance->getCreatedBy() instanceof UserInterface);
        Assert::assertTrue($this->deviceInstance->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->deviceInstance->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->deviceInstance->getModifiedAt() instanceof DateTime);

        if ($this->deviceInstance->getParentId() instanceof DeviceInstanceId) {
            Assert::assertTrue($this->deviceInstance->getParentId() instanceof DeviceInstanceId);
        }
    }
}
