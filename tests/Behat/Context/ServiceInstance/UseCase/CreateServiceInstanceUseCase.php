<?php

namespace App\Tests\Behat\Context\ServiceInstance\UseCase;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommand;
use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Component\UUID\UUID;
use App\App\UseCase\ServiceInstance\CreateServiceInstanceUseCaseInterface;
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
use DateTime;
use PHPUnit\Framework\Assert;

class CreateServiceInstanceUseCase implements Context
{
    /** @var ServiceInstanceInterface */
    private $result;
    /** @var CreateServiceInstanceUseCaseInterface */
    private $createServiceInstanceUseCase;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateServiceInstanceCommandInterface */
    private $createServiceInstanceCommand;

    /**
     * CreateServiceInstanceUseCase constructor.
     * @param CreateServiceInstanceUseCaseInterface $createServiceInstanceUseCase
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        CreateServiceInstanceUseCaseInterface $createServiceInstanceUseCase,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->createServiceInstanceUseCase = $createServiceInstanceUseCase;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I'm set CreateServiceInstanceCommandInterface
     */
    public function imSetCreateserviceinstancecommandinterface()
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
    }

    /**
     * @When I call method create
     */
    public function iCallMethodCreate()
    {
        $this->result = $this->createServiceInstanceUseCase->create($this->createServiceInstanceCommand);
    }

    /**
     * @Then I should get ServiceInstanceInterface
     */
    public function iShouldGetServiceinstanceinterface()
    {
        Assert::assertTrue($this->result instanceof ServiceInstanceInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getModifiedAt() instanceof DateTime);
        Assert::assertTrue($this->result->getCreatedAt() instanceof DateTime);
    }
}
