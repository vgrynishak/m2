<?php

namespace App\Tests\Behat\Context\Service\Doctrine\Mapper;

use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Mapper\Service\ServiceModelInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\Facility;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\Service;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Facility\FacilityQueryRepositoryInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class MapService implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var ServiceInterface */
    private $service;

    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;

    /** @var FacilityQueryRepositoryInterface */
    private $facilityQueryRepository;

    /** @var ServiceModelInterface */
    private $mapper;

    /** @var ServiceEntity */
    private $result;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * MapService constructor.
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param FacilityQueryRepositoryInterface $facilityQueryRepository
     * @param ServiceModelInterface $mapper
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        FacilityQueryRepositoryInterface $facilityQueryRepository,
        ServiceModelInterface $mapper,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->facilityQueryRepository = $facilityQueryRepository;
        $this->mapper = $mapper;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm Set exists Service model
     */
    public function imSetExistsServiceModel()
    {
        /** @var ServiceId $serviceId */
        $serviceId = new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1');
        $this->service = $this->serviceQueryRepository->find($serviceId);
    }

    /**
     * @Given I'm Set new Service model
     */
    public function imSetNewServiceModel()
    {
        /** @var FacilityId $facilityId */
        $facilityId = new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9');
        /** @var Facility $facility */
        $facility = $this->facilityQueryRepository->find($facilityId);
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->service = new Service(
            new ServiceId('8bb24600-d98c-4f0f-96fc-e5ce1bebaeda'),
            new DeviceId('0456cf66-177f-4186-8978-d332102b31ff'),
            $facility,
            'New TEST Service Name'
        );

        $this->service->setComment('TEST Comment');
        $this->service->setCreatedAt(new DateTime());
        $this->service->setUpdatedAt(new DateTime());
        $this->service->setCreatedBy($user);
        $this->service->setModifiedBy($user);
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->service);
    }

    /**
     * @When I Call Method MapNew
     */
    public function iCallMethodMapnew()
    {
        $this->result = $this->mapper->mapNew($this->service);
    }

    /**
     * @Then I should get same ServiceEntity
     */
    public function iShouldGetSameServiceentity()
    {
        Assert::assertEquals($this->result->getId(), $this->service->getId()->getValue());
        Assert::assertEquals($this->result->getName(), $this->service->getName());
        Assert::assertEquals($this->result->getDevice()->getId(), $this->service->getDeviceId()->getValue());
        Assert::assertEquals($this->result->getFacility()->getId(), $this->service->getFacility()->getId()->getValue());
        Assert::assertEquals($this->result->getComment(), $this->service->getComment());
        Assert::assertEquals($this->result->getCreatedAt(), $this->service->getCreatedAt());
        Assert::assertEquals($this->result->getUpdatedAt(), $this->service->getUpdatedAt());
        Assert::assertEquals($this->result->getCreatedBy()->getId(), $this->service->getCreatedBy()->getId());
        Assert::assertEquals($this->result->getModifiedBy()->getId(), $this->service->getModifiedBy()->getId());
    }
}
