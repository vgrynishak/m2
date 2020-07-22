<?php

namespace App\Tests\Behat\Context\ServiceInstance\CommandRepository;

use App\App\Component\UUID\UUID;
use App\App\Doctrine\Entity\ServiceInstance as ServiceInstanceEntity;
use App\App\Doctrine\Repository\ServiceInstanceRepository;
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
use App\Core\Repository\ServiceInstance\ServiceInstanceCommandRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class ServiceInstanceCommandRepository implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ServiceInstanceInterface */
    private $serviceInstance;
    /** @var ServiceQueryRepositoryInterface */
    private $serviceQueryRepository;
    /** @var ServiceInstanceEntity | null */
    private $serviceInstanceEntity;
    /** @var ServiceInstanceCommandRepositoryInterface */
    private $serviceInstanceCommandRepository;
    /** @var Connection */
    private $doctrineConnection;
    /** @var ServiceInstanceRepository */
    private $serviceInstanceRepository;

    /**
     * ServiceInstanceCommandRepository constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ServiceQueryRepositoryInterface $serviceQueryRepository
     * @param ServiceInstanceCommandRepositoryInterface $serviceInstanceCommandRepository
     * @param Connection $connection
     * @param ServiceInstanceRepository $serviceInstanceRepository
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ServiceQueryRepositoryInterface $serviceQueryRepository,
        ServiceInstanceCommandRepositoryInterface $serviceInstanceCommandRepository,
        Connection $connection,
        ServiceInstanceRepository $serviceInstanceRepository
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->serviceQueryRepository = $serviceQueryRepository;
        $this->serviceInstanceCommandRepository = $serviceInstanceCommandRepository;
        $this->doctrineConnection = $connection;
        $this->serviceInstanceRepository = $serviceInstanceRepository;
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I'm set new ServiceInstanceInterface which I want to create
     */
    public function imSetNewServiceinstanceinterfaceWhichIWantToCreate()
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
     * @throws ConnectionException
     * @When I Call Method Create
     */
    public function iCallMethodCreate()
    {
        $this->doctrineConnection->beginTransaction();

        $this->serviceInstanceCommandRepository->create($this->serviceInstance);
        $this->serviceInstanceEntity = $this->serviceInstanceRepository->find(
            $this->serviceInstance->getId()->getValue()
        );
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get new ServiceInstanceEntity
     */
    public function iShouldGetNewServiceinstanceentity()
    {
        Assert::assertTrue($this->serviceInstanceEntity instanceof ServiceInstanceEntity);
    }
}
