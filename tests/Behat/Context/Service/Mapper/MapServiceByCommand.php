<?php

namespace App\Tests\Behat\Context\Service\Mapper;

use App\App\Command\Service\CreateServiceCommand;
use App\App\Command\Service\CreateServiceCommandInterface;
use App\App\Command\Service\Mapper\ServiceMapperByCommandInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapServiceByCommand implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var ServiceInterface */
    private $result;

    /** @var CreateServiceCommandInterface */
    private $command;

    /** @var ServiceMapperByCommandInterface */
    private $mapper;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * MapServiceByCommand constructor.
     * @param ServiceMapperByCommandInterface $mapper
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        ServiceMapperByCommandInterface $mapper,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->mapper = $mapper;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I’m set correct command implements CreateServiceCommandInterface
     */
    public function imSetCorrectCommandImplementsCreateservicecommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->command = new CreateServiceCommand(
            new ServiceId('6a703f9a-8113-46a5-b440-cb4318e223cf'),
            new DeviceId('081a5bbd-d5fe-4838-867e-5b7e3af7bf91'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            'New Service Test 2'
        );

        $this->command->setComment('New Test Comment');
        $this->command->setCreatedBy($user);
        $this->command->setModifiedBy($user);
    }

    /**
     * @When I call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->command);
    }

    /**
     * @Then I should get Service that implements ServiceInterface
     */
    public function iShouldGetServiceThatImplementsServiceinterface()
    {
        Assert::assertTrue($this->result instanceof ServiceInterface);
    }

    /**
     * @Then I should get same Service properties
     */
    public function iShouldGetSameServiceProperties()
    {
        Assert::assertEquals($this->result->getId(), $this->command->getId());
        Assert::assertEquals($this->result->getDeviceId(), $this->command->getDeviceId());
        Assert::assertEquals($this->result->getFacility()->getId(), $this->command->getFacilityId());
        Assert::assertEquals($this->result->getName(), $this->command->getName());
        Assert::assertEquals($this->result->getComment(), $this->command->getComment());
        Assert::assertEquals($this->result->getCreatedBy(), $this->command->getCreatedBy());
        Assert::assertEquals($this->result->getModifiedBy(), $this->command->getModifiedBy());
    }
}
