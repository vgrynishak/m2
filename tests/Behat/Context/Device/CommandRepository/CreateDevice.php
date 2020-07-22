<?php

namespace App\Tests\Behat\Context\Device\CommandRepository;

use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceCommandRepositoryInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class CreateDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var DeviceCommandRepositoryInterface */
    private $deviceCommandRepository;
    /** @var DeviceInterface */
    private $device;
    /** @var Connection */
    private $doctrineConnection;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceInterface */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateDevice constructor.
     * @param DeviceCommandRepositoryInterface $deviceCommandRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param Connection $connection
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        DeviceCommandRepositoryInterface $deviceCommandRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        Connection $connection,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->deviceCommandRepository = $deviceCommandRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->doctrineConnection = $connection;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm Set correct Device model
     */
    public function imSetCorrectDeviceModel()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);
        /** @var DivisionId $divisionId */
        $divisionId = new DivisionId('6a38e866-e068-42f8-b21f-e5000389b6fd');
        /** @var DeviceId $deviceId */
        $deviceId = new DeviceId('f218cebe-c06a-4731-8c68-3c2e3abf2ce2');
        /** @var DeviceInterface device */
        $this->device = new Device(
            $deviceId,
            'New test Device',
            1,
            $divisionId,
            'general_plumbing'
        );

        /** @var DeviceId $parentDeviceId */
        $parentDeviceId = new DeviceId('072c14b3-3d37-4591-bbee-27b3850d416d');

        $this->device->setParentId($parentDeviceId);
        $this->device->setCreatedAt(new \DateTime());
        $this->device->setUpdatedAt(new \DateTime());
        $this->device->setDescription('New Test Description');
        $this->device->setCreatedBy($user);
        $this->device->setModifiedBy($user);
    }

    /**
     * @When I Call Method Create
     * @throws ConnectionException
     */
    public function iCallMethodCreate()
    {
        $this->doctrineConnection->beginTransaction();
        $this->deviceCommandRepository->create($this->device);
        $this->result = $this->deviceQueryRepository->find($this->device->getId());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get created device
     */
    public function iShouldGetCreatedDevice()
    {
        Assert::assertTrue($this->result instanceof DeviceInterface);
    }
}
