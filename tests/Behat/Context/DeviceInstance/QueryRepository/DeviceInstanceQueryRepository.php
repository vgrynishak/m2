<?php

namespace App\Tests\Behat\Context\DeviceInstance\QueryRepository;

use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class DeviceInstanceQueryRepository implements Context
{
    /** @var DeviceInstanceQueryRepositoryInterface */
    private $deviceInstanceQueryRepository;
    /** @var DeviceInstanceId */
    private $deviceInstanceId;
    /** @var DeviceInstanceInterface | null */
    private $deviceInstance;

    /**
     * DeviceInstanceQueryRepository constructor.
     * @param DeviceInstanceQueryRepositoryInterface $deviceInstanceQueryRepository
     */
    public function __construct(DeviceInstanceQueryRepositoryInterface $deviceInstanceQueryRepository)
    {
        $this->deviceInstanceQueryRepository = $deviceInstanceQueryRepository;
    }

    /**
     * @Given I'm set DeviceInstanceId
     */
    public function imSetDeviceinstanceid()
    {
        $this->deviceInstanceId = new DeviceInstanceId('d6306c0a-3b9c-11ea-b77f-2e728ce88125');
    }

    /**
     * @When I Call Method find
     */
    public function iCallMethodFind()
    {
        $this->deviceInstance = $this->deviceInstanceQueryRepository->find($this->deviceInstanceId);
    }

    /**
     * @Then I should get DeviceInstanceInterface
     */
    public function iShouldGetDeviceinstanceinterface()
    {
        Assert::assertTrue($this->deviceInstance instanceof DeviceInstanceInterface);
    }

    /**
     * @Given I'm set incorrect DeviceInstanceId
     */
    public function imSetIncorrectDeviceinstanceid()
    {
        $this->deviceInstanceId = new DeviceInstanceId('d6306c0a-3b9c-11ea-b77f-2e728ce88124');
    }

    /**
     * @Then I should not get DeviceInstanceInterface
     */
    public function iShouldNotGetDeviceinstanceinterface()
    {
        Assert::assertTrue(!$this->deviceInstance instanceof DeviceInstanceInterface);
    }
}
