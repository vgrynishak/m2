<?php

namespace App\Tests\Behat\Context\ServiceInstance\Mapper;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommand;
use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Command\ServiceInstance\Mapper\ServiceInstanceMapperByCommandInterface;
use App\App\Component\UUID\UUID;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\ServiceInstance\ServiceInstanceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapServiceInstanceByCommand implements Context
{
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateServiceInstanceCommandInterface */
    private $createServiceInstanceCommand;
    /** @var ServiceInstanceInterface */
    private $result;
    /** @var ServiceInstanceMapperByCommandInterface */
    private $mapper;

    /**
     * MapServiceInstanceByCommand constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ServiceInstanceMapperByCommandInterface $mapper
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ServiceInstanceMapperByCommandInterface $mapper
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->mapper = $mapper;
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I’m set correct CreateServiceInstanceCommand
     */
    public function imSetCorrectCreateserviceinstancecommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newServiceInstanceUUID */
        $newServiceInstanceUUID = new UUID();

        $this->createServiceInstanceCommand = new CreateServiceInstanceCommand(
            new ServiceInstanceId($newServiceInstanceUUID->getValue()),
            new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            $user
        );

        $this->createServiceInstanceCommand->setModifiedBy($user);
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->createServiceInstanceCommand);
    }

    /**
     * @Then I should get ServiceInstance that Implements ServiceInstanceInterface
     */
    public function iShouldGetServiceinstanceThatImplementsServiceinstanceinterface()
    {
        Assert::assertTrue($this->result instanceof ServiceInstanceInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getCreatedBy() instanceof UserInterface);
    }
}
