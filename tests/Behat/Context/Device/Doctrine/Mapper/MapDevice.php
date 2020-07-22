<?php

namespace App\Tests\Behat\Context\Device\Doctrine\Mapper;

use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Mapper\Device\DeviceModelInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var DeviceInterface */
    private $device;
    /** @var DeviceEntity */
    private $result;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceModelInterface */
    private $mapper;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * MapDevice constructor.
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DeviceModelInterface $mapper
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DeviceModelInterface $mapper,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->mapper = $mapper;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm Set exists Device model
     */
    public function imSetExistsDeviceModel()
    {
        /** @var DeviceId $deviceId */
        $deviceId = new DeviceId('04eeff15-d30b-4a28-9c6c-52697c56d161');
        $this->device = $this->deviceQueryRepository->find($deviceId);
    }

    /**
     * @Given I'm Set new Device model
     */
    public function imSetNewDeviceModel()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);
        /** @var DeviceId $deviceId */
        $deviceId = new DeviceId('15ed1ce6-cf04-47ed-ae2e-12541fe452c5');
        /** @var DivisionId $divisionId */
        $divisionId = new DivisionId('6a38e866-e068-42f8-b21f-e5000389b6fd');

        $this->device = new Device(
            $deviceId,
            'New Backflow Device',
            1,
            $divisionId,
            'backflow_device'
        );

        /** @var DeviceId $parentDeviceId */
        $parentDeviceId = new DeviceId('cdc6b2fc-3e53-46da-a98b-fe9006c568e1');

        $this->device->setParentId($parentDeviceId);
        $this->device->setCreatedAt(new \DateTime());
        $this->device->setUpdatedAt(new \DateTime());
        $this->device->setDescription('New Test Description');
        $this->device->setCreatedBy($user);
        $this->device->setModifiedBy($user);
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->device);
    }

    /**
     * @When I Call Method MapNew
     */
    public function iCallMethodMapnew()
    {
        $this->result = $this->mapper->mapNew($this->device);
    }

    /**
     * @Then I should get same DeviceEntity
     */
    public function iShouldGetSameDeviceentity()
    {
        Assert::assertEquals($this->result->getId(), $this->device->getId()->getValue());
        Assert::assertEquals($this->result->getName(), $this->device->getName());
        Assert::assertEquals($this->result->getCreatedAt(), $this->device->getCreatedAt());
        Assert::assertEquals($this->result->getUpdatedAt(), $this->device->getUpdatedAt());
        Assert::assertEquals($this->result->getParent()->getId(), $this->device->getParentId()->getValue());
        Assert::assertEquals($this->result->getDivision()->getId(), $this->device->getDivisionId()->getValue());
        Assert::assertEquals($this->result->getDescription(), $this->device->getDescription());
        Assert::assertEquals($this->result->getLevel(), $this->device->getLevel());
        Assert::assertEquals($this->result->getAlias(), $this->device->getAlias());
    }
}
