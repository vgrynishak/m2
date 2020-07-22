<?php

namespace App\Tests\Behat\Context\DeviceInstance\Mapper;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommand;
use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Command\DeviceInstance\Mapper\DeviceInstanceMapperByCommandInterface;
use App\App\Component\UUID\UUID;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapDeviceInstanceByCommand implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateDeviceInstanceCommandInterface */
    private $createDeviceInstanceCommand;
    /** @var DeviceInstanceInterface */
    private $result;
    /** @var DeviceInstanceMapperByCommandInterface */
    private $mapper;

    /**
     * MapDeviceInstanceByCommand constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeviceInstanceMapperByCommandInterface $mapper
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeviceInstanceMapperByCommandInterface $mapper
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->mapper = $mapper;
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidFacilityIdException
     * @Given I’m set correct CreateDeviceInstanceCommand
     */
    public function imSetCorrectCreatedeviceinstancecommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newDeviceInstanceUUID */
        $newDeviceInstanceUUID = new UUID();
        /** @var UUID $newParentDeviceInstanceUUID */
        $newParentDeviceInstanceUUID = new UUID();

        $this->createDeviceInstanceCommand = new CreateDeviceInstanceCommand(
            new DeviceInstanceId($newDeviceInstanceUUID->getValue()),
            new DeviceId('0456cf66-177f-4186-8978-d332102b31ff'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            $user
        );

        $this->createDeviceInstanceCommand->setModifiedBy($user);
        $this->createDeviceInstanceCommand->setParentId(new DeviceInstanceId($newParentDeviceInstanceUUID->getValue()));
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->createDeviceInstanceCommand);
    }

    /**
     * @Then I should get DeviceInstance that Implements DeviceInstanceInterface
     */
    public function iShouldGetDeviceinstanceThatImplementsDeviceinstanceinterface()
    {
        Assert::assertTrue($this->result instanceof DeviceInstanceInterface);
        Assert::assertTrue($this->result->getParentId() instanceof DeviceInstanceId);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getCreatedBy() instanceof UserInterface);
    }
}
