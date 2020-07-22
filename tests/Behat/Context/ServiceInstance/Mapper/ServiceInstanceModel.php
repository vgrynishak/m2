<?php

namespace App\Tests\Behat\Context\ServiceInstance\Mapper;

use App\App\Component\UUID\UUID;
use App\App\Doctrine\Mapper\ServiceInstance\ServiceInstanceModelInterface;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\ServiceInstance\ServiceInstance;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Service\ServiceQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use App\App\Doctrine\Entity\Service as ServiceEntity;
use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Entity\Facility as FacilityEntity;
use App\App\Doctrine\Entity\User as UserEntity;
use DateTime;
use PHPUnit\Framework\Assert;

class ServiceInstanceModel implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ServiceInstanceModelInterface */
    private $serviceInstanceModelMapper;
    /** @var ServiceInstanceInterface */
    private $serviceInstance;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var ServiceInstanceEntity */
    private $serviceInstanceEntity;

    /**
     * ServiceInstanceModel constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ServiceInstanceModelInterface $serviceInstanceModelMapper
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ServiceInstanceModelInterface $serviceInstanceModelMapper,
        ServiceQueryRepositoryInterface $serviceQueryRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->serviceInstanceModelMapper = $serviceInstanceModelMapper;
        $this->serviceQueryRepository = $serviceQueryRepository;
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I’m set correct ServiceInstanceInterface
     */
    public function imSetCorrectServiceinstanceinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newServiceInstanceUUID */
        $newServiceInstanceUUID = new UUID();
        /** @var ServiceInterface $service */
        $service = $this->serviceQueryRepository->find(new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1'));

        $this->serviceInstance = new ServiceInstance(
            new ServiceInstanceId($newServiceInstanceUUID->getValue()),
            $service,
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9')
        );
        $this->serviceInstance->setModifiedBy($user);
        $this->serviceInstance->setCreatedBy($user);
        $this->serviceInstance->setCreatedAt(new DateTime());
        $this->serviceInstance->setModifiedAt(new DateTime());
    }

    /**
     * @When I call Method mapNew
     */
    public function iCallMethodMapnew()
    {
        $this->serviceInstanceEntity = $this->serviceInstanceModelMapper->mapNew($this->serviceInstance);
    }

    /**
     * @Then I should get ServiceInstanceEntity that Implements ServiceInstanceEntity
     */
    public function iShouldGetServiceinstanceentityThatImplementsServiceinstanceentity()
    {
        Assert::assertTrue($this->serviceInstanceEntity instanceof ServiceInstanceEntity);
        Assert::assertTrue($this->serviceInstanceEntity->getCreatedBy() instanceof UserEntity);
        Assert::assertTrue($this->serviceInstanceEntity->getModifiedBy() instanceof UserEntity);
        Assert::assertTrue($this->serviceInstanceEntity->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->serviceInstanceEntity->getUpdatedAt() instanceof DateTime);
        Assert::assertTrue($this->serviceInstanceEntity->getService() instanceof ServiceEntity);
        Assert::assertTrue($this->serviceInstanceEntity->getFacility() instanceof FacilityEntity);
    }
}
