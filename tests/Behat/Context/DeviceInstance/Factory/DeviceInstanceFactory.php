<?php

namespace App\Tests\Behat\Context\DeviceInstance\Factory;

use App\App\Component\UUID\UUID;
use App\App\Factory\DeviceInstance\DeviceInstanceFactoryInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Exception;

class DeviceInstanceFactory implements Context
{
    /** @var array */
    private $correctParams = [];
    /** @var DeviceInstanceFactoryInterface */
    private $deviceInstanceFactory;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceInstanceInterface */
    private $result;

    /**
     * DeviceInstanceFactory constructor.
     * @param DeviceInstanceFactoryInterface $deviceInstanceFactory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     */
    public function __construct(
        DeviceInstanceFactoryInterface $deviceInstanceFactory,
        DeviceQueryRepositoryInterface $deviceQueryRepository
    ) {
        $this->deviceInstanceFactory = $deviceInstanceFactory;
        $this->deviceQueryRepository = $deviceQueryRepository;
    }

    /**
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidDeviceIdException
     * @throws InvalidFacilityIdException
     * @Given I'm Set Correct Params For DeviceInstance
     */
    public function imSetCorrectParamsForDeviceinstance()
    {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find(new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'));
        /** @var UUID $newUUID */
        $newUUID = new UUID();

        $this->correctParams['id'] = new DeviceInstanceId($newUUID->getValue());
        $this->correctParams['device'] = $device;
        $this->correctParams['facilityId'] = new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9');
    }

    /**
     * @When I Call Method make
     */
    public function iCallMethodMake()
    {
        $this->result = $this->deviceInstanceFactory->make(
            $this->correctParams['id'],
            $this->correctParams['device'],
            $this->correctParams['facilityId']
        );
    }

    /**
     * @throws Exception
     * @Then I Should Get Correct DeviceInstance
     */
    public function iShouldGetCorrectDeviceinstance()
    {
        if (!$this->result instanceof DeviceInstanceInterface) {
            throw new Exception("Result is not implemented DeviceInstanceInterface");
        }

        $this->checkBaseField();
    }

    /**
     * @throws Exception
     */
    private function checkBaseField()
    {
        if (!$this->result->getCreatedAt() instanceof DateTime) {
            throw new Exception("DeviceInstance does`t has createdAt field");
        }

        if (!$this->result->getModifiedAt() instanceof DateTime) {
            throw new Exception("DeviceInstance does`t has modifiedAt field");
        }
    }
}
