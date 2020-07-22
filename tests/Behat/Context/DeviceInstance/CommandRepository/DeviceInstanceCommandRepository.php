<?php

namespace App\Tests\Behat\Context\DeviceInstance\CommandRepository;

use App\App\Component\UUID\UUID;
use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Repository\DeviceInstanceRepository;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstance;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\DeviceInstance\DeviceInstanceCommandRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class DeviceInstanceCommandRepository implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeviceInstanceInterface */
    private $deviceInstance;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceInstanceEntity | null */
    private $deviceInstanceEntity;
    /** @var DeviceInstanceCommandRepositoryInterface */
    private $deviceInstanceCommandRepository;
    /** @var Connection */
    private $doctrineConnection;
    /** @var DeviceInstanceRepository */
    private $deviceInstanceRepository;

    /**
     * DeviceInstanceCommandRepository constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param DeviceInstanceCommandRepositoryInterface $deviceInstanceCommandRepository
     * @param Connection $connection
     * @param DeviceInstanceRepository $deviceInstanceRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        DeviceInstanceCommandRepositoryInterface $deviceInstanceCommandRepository,
        Connection $connection,
        DeviceInstanceRepository $deviceInstanceRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->deviceInstanceCommandRepository = $deviceInstanceCommandRepository;
        $this->doctrineConnection = $connection;
        $this->deviceInstanceRepository = $deviceInstanceRepository;
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidFacilityIdException
     * @Given I'm set new DeviceInstanceInterface which I want to create
     */
    public function imSetNewDeviceinstanceinterfaceWhichIWantToCreate()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newDeviceInstanceUUID */
        $newDeviceInstanceUUID = new UUID();
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find(new DeviceId('0456cf66-177f-4186-8978-d332102b31ff'));

        $this->deviceInstance = new DeviceInstance(
            new DeviceInstanceId($newDeviceInstanceUUID->getValue()),
            $device,
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9')
        );
        $this->deviceInstance->setModifiedBy($user);
        $this->deviceInstance->setCreatedBy($user);
        $this->deviceInstance->setCreatedAt(new DateTime());
        $this->deviceInstance->setModifiedAt(new DateTime());
    }

    /**
     * @throws ConnectionException
     * @When I Call Method Create
     */
    public function iCallMethodCreate()
    {
        $this->doctrineConnection->beginTransaction();

        $this->deviceInstanceCommandRepository->create($this->deviceInstance);
        $this->deviceInstanceEntity = $this->deviceInstanceRepository->find($this->deviceInstance->getId()->getValue());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get new DeviceInstanceEntity
     */
    public function iShouldGetNewDeviceinstanceentity()
    {
        Assert::assertTrue($this->deviceInstanceEntity instanceof DeviceInstanceEntity);
    }
}
