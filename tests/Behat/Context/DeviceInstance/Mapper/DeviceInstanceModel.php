<?php

namespace App\Tests\Behat\Context\DeviceInstance\Mapper;

use App\App\Component\UUID\UUID;
use App\App\Doctrine\Mapper\DeviceInstance\DeviceInstanceModelInterface;
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
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use App\App\Doctrine\Entity\Device as DeviceEntity;
use App\App\Doctrine\Entity\DeviceInstance as DeviceInstanceEntity;
use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use DateTime;
use PHPUnit\Framework\Assert;

class DeviceInstanceModel implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var DeviceInstanceModelInterface */
    private $deviceInstanceModelMapper;
    /** @var DeviceInstanceInterface */
    private $deviceInstance;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var DeviceInstanceEntity */
    private $deviceInstanceEntity;

    /**
     * DeviceInstanceModel constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeviceInstanceModelInterface $deviceInstanceModelMapper
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeviceInstanceModelInterface $deviceInstanceModelMapper,
        DeviceQueryRepositoryInterface $deviceQueryRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->deviceInstanceModelMapper = $deviceInstanceModelMapper;
        $this->deviceQueryRepository = $deviceQueryRepository;
    }

    /**
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidDeviceIdException
     * @throws InvalidFacilityIdException
     * @Given I’m set correct DeviceInstanceInterface
     */
    public function imSetCorrectDeviceinstanceinterface()
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
     * @When I call Method mapNew
     */
    public function iCallMethodMapnew()
    {
        $this->deviceInstanceEntity = $this->deviceInstanceModelMapper->mapNew($this->deviceInstance);
    }

    /**
     * @Then I should get DeviceInstanceEntity that Implements DeviceInstanceEntity
     */
    public function iShouldGetDeviceinstanceentityThatImplementsDeviceinstanceentity()
    {
        Assert::assertTrue($this->deviceInstanceEntity instanceof DeviceInstanceEntity);
        Assert::assertTrue($this->deviceInstanceEntity->getCreatedBy() instanceof UserEntity);
        Assert::assertTrue($this->deviceInstanceEntity->getModifiedBy() instanceof UserEntity);
        Assert::assertTrue($this->deviceInstanceEntity->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->deviceInstanceEntity->getUpdatedAt() instanceof DateTime);
        Assert::assertTrue($this->deviceInstanceEntity->getDevice() instanceof DeviceEntity);
        Assert::assertTrue($this->deviceInstanceEntity->getFacility() instanceof FacilityEntity);
    }
}
