<?php

namespace App\Tests\Behat\Context\InfoSource\Mapper;

use App\App\Doctrine\Repository\DeviceDynamicFieldRepository;
use App\App\Mapper\DeviceDynamicField\DoctrineEntityDeviceDynamicFieldMapperInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapDeviceDynamicFieldFromEntityToModel implements Context
{
    /** @var DeviceDynamicFieldRepository */
    private $deviceDynamicFieldRepository;
    /** @var DoctrineEntityDeviceDynamicFieldMapperInterface */
    private $doctrineEntityDeviceDynamicFieldMapper;
    /** @var DeviceDynamicFieldEntity */
    private $deviceDynamicFieldEntity;
    /** @var DeviceDynamicFieldInterface */
    private $deviceDynamicField;

    /**
     * MapDeviceDynamicFieldFromEntityToModel constructor.
     * @param DeviceDynamicFieldRepository $deviceDynamicFieldRepository
     * @param DoctrineEntityDeviceDynamicFieldMapperInterface $doctrineEntityDeviceDynamicFieldMapper
     */
    public function __construct(
        DeviceDynamicFieldRepository $deviceDynamicFieldRepository,
        DoctrineEntityDeviceDynamicFieldMapperInterface $doctrineEntityDeviceDynamicFieldMapper
    ) {
        $this->deviceDynamicFieldRepository = $deviceDynamicFieldRepository;
        $this->doctrineEntityDeviceDynamicFieldMapper = $doctrineEntityDeviceDynamicFieldMapper;
    }

    /**
     * @Given I’m find and set correct DeviceDynamicFieldEntity
     */
    public function imFindAndSetCorrectDevicedynamicfieldentity()
    {
        $this->deviceDynamicFieldEntity =
            $this->deviceDynamicFieldRepository->find('backflow_size');
    }

    /**
     * @When I call Method map
     */
    public function iCallMethodMap()
    {
        $this->deviceDynamicField = $this->doctrineEntityDeviceDynamicFieldMapper->map($this->deviceDynamicFieldEntity);
    }

    /**
     * @Then I should get DeviceDynamicField that Implements DeviceDynamicFieldInterface
     */
    public function iShouldGetDevicedynamicfieldThatImplementsDevicedynamicfieldinterface()
    {
        Assert::assertTrue($this->deviceDynamicField instanceof DeviceDynamicFieldInterface);
        Assert::assertTrue($this->deviceDynamicField->getDeviceId() instanceof DeviceId);
    }
}
