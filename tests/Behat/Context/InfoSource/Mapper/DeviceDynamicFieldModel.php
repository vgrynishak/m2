<?php

namespace App\Tests\Behat\Context\InfoSource\Mapper;

use App\App\Doctrine\Mapper\DeviceDynamicField\DeviceDynamicFieldModelInterface;
use App\App\Doctrine\Repository\DeviceRepository;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceDynamicField\DeviceDynamicField;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldId;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\DeviceDynamicField as DeviceDynamicFieldEntity;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use PHPUnit\Framework\Assert;

class DeviceDynamicFieldModel implements Context
{
    /** @var DeviceDynamicFieldModelInterface */
    private $dynamicFieldMapper;
    /** @var DeviceDynamicFieldEntity[] | null */
    private $deviceDynamicFieldEntities = [];
    /** @var CollectionInterface */
    private $dynamicFields;
    /** @var DeviceRepository */
    private $deviceRepository;
    /** @var DeviceEntity */
    private $deviceEntity;

    /**
     * DeviceDynamicFieldModel constructor.
     * @param DeviceDynamicFieldModelInterface $dynamicFieldMapper
     * @param DeviceRepository $deviceRepository
     */
    public function __construct(
        DeviceDynamicFieldModelInterface $dynamicFieldMapper,
        DeviceRepository $deviceRepository
    ) {
        $this->dynamicFieldMapper = $dynamicFieldMapper;
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @Given I’m set correct DeviceInterface which contain new DeviceDynamicFieldInterfaceCollection
     */
    public function imSetCorrectDevicedynamicfieldinterface()
    {
        /** @var DeviceDynamicFieldInterface[] $ddf */
        $ddf = [];
        $this->deviceEntity =
            $this->deviceRepository->find('63bea125-46f1-4d59-b6ec-65000d13ac1f');

        $ddf[] = new DeviceDynamicField(
            new DeviceDynamicFieldId('new_ddf'),
            new DeviceId('53bf1a97-00cd-4218-906f-5621c667c257'),
            'test'
        );
        $this->dynamicFields = new Set($ddf);
    }

    /**
     * @When I call Method mapNewByDevice
     */
    public function iCallMethodMapnew()
    {
        $this->deviceDynamicFieldEntities =
            $this->dynamicFieldMapper->mapNewByDevice($this->dynamicFields, $this->deviceEntity);
    }

    /**
     * @Then I should get DeviceDynamicFieldEntityCollection that Implements DeviceDynamicFieldEntity
     */
    public function iShouldGetDevicedynamicfieldentityThatImplementsDevicedynamicfieldentity()
    {
        /** @var DeviceDynamicFieldEntity $deviceDynamicFieldEntity */
        foreach ($this->deviceDynamicFieldEntities as $deviceDynamicFieldEntity) {
            Assert::assertTrue($deviceDynamicFieldEntity instanceof DeviceDynamicFieldEntity);
            Assert::assertTrue($deviceDynamicFieldEntity->getDevice() instanceof DeviceEntity);
        }
    }
}
