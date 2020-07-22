<?php

namespace App\Tests\Behat\Context\DeviceInstance\UseCase;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommand;
use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Component\UUID\UUID;
use App\App\UseCase\DeviceInstance\CreateDeviceInstanceUseCaseInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\DeviceInstance\DeviceInstanceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PHPUnit\Framework\Assert;

class CreateDeviceInstanceUseCase implements Context
{
    /** @var DeviceInstanceInterface */
    private $result;
    /** @var CreateDeviceInstanceUseCaseInterface */
    private $createDeviceInstanceUseCase;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateDeviceInstanceCommandInterface */
    private $createDeviceInstanceCommand;

    /**
     * CreateDeviceInstanceUseCase constructor.
     * @param CreateDeviceInstanceUseCaseInterface $createDeviceInstanceUseCase
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        CreateDeviceInstanceUseCaseInterface $createDeviceInstanceUseCase,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->createDeviceInstanceUseCase = $createDeviceInstanceUseCase;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidFacilityIdException
     * @Given I'm set CreateDeviceInstanceCommandInterface
     */
    public function imSetCreatedeviceinstancecommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newDeviceInstanceUUID */
        $newDeviceInstanceUUID = new UUID();

        $this->createDeviceInstanceCommand = new CreateDeviceInstanceCommand(
            new DeviceInstanceId($newDeviceInstanceUUID->getValue()),
            new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            $user
        );
    }

    /**
     * @When I call method create
     */
    public function iCallMethodCreate()
    {
        $this->result = $this->createDeviceInstanceUseCase->create($this->createDeviceInstanceCommand);
    }

    /**
     * @Then I should get DeviceInstanceInterface
     */
    public function iShouldGetDeviceinstanceinterface()
    {
        Assert::assertTrue($this->result instanceof DeviceInstanceInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getModifiedAt() instanceof DateTime);
        Assert::assertTrue($this->result->getCreatedAt() instanceof DateTime);
    }
}
