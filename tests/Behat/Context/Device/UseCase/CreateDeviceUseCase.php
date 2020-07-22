<?php

namespace App\Tests\Behat\Context\Device\UseCase;

use App\App\Command\Device\CreateDeviceCommand;
use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Component\UUID\UUID;
use App\App\UseCase\Device\CreateDeviceUseCaseInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\DeviceDynamicField\DeviceDynamicField;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldId;
use App\Core\Model\DeviceDynamicField\DeviceDynamicFieldInterface;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\Exception\InvalidDeviceDynamicFieldIdException;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use PhpCollection\CollectionInterface;
use PhpCollection\Set;
use PHPUnit\Framework\Assert;

class CreateDeviceUseCase implements Context
{
    /** @var DeviceInterface */
    private $result;
    /** @var CreateDeviceUseCaseInterface */
    private $createDeviceUseCase;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateDeviceCommandInterface */
    private $createDeviceCommand;

    /**
     * CreateDeviceUseCase constructor.
     * @param CreateDeviceUseCaseInterface $createDeviceUseCase
     * @param UserQueryRepositoryInterface $userQueryRepository
     */
    public function __construct(
        CreateDeviceUseCaseInterface $createDeviceUseCase,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->createDeviceUseCase = $createDeviceUseCase;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceDynamicFieldIdException
     * @throws InvalidDivisionIdException
     * @Given I'm set CreateDeviceCommandInterface
     */
    public function imSetCreatedevicecommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(1);
        /** @var UUID $newDeviceUUID */
        $newDeviceUUID = new UUID();
        /** @var DeviceDynamicFieldInterface[] $dynamicFields */
        $dynamicFields = [];

        $this->createDeviceCommand = new CreateDeviceCommand(
            new DeviceId($newDeviceUUID->getValue()),
            'test',
            new DivisionId('6a38e866-e068-42f8-b21f-e5000389b6fd'),
            1,
            'test',
            $user
        );

        $dynamicFields[] = new DeviceDynamicField(
            new DeviceDynamicFieldId('test_1'),
            new DeviceId($newDeviceUUID->getValue()),
            'test_1'
        );
        $dynamicFields[] = new DeviceDynamicField(
            new DeviceDynamicFieldId('test_2'),
            new DeviceId($newDeviceUUID->getValue()),
            'test_2'
        );
        $this->createDeviceCommand->setDynamicFields(new Set($dynamicFields));
    }

    /**
     * @When I call method create
     */
    public function iCallMethodCreate()
    {
        $this->result = $this->createDeviceUseCase->create($this->createDeviceCommand);
    }

    /**
     * @Then I should get DeviceInterface
     */
    public function iShouldGetDeviceinterface()
    {
        Assert::assertTrue($this->result instanceof DeviceInterface);
        Assert::assertTrue($this->result->getModifiedBy() instanceof UserInterface);
        Assert::assertTrue($this->result->getUpdatedAt() instanceof DateTime);
        Assert::assertTrue($this->result->getCreatedAt() instanceof DateTime);
        Assert::assertTrue($this->result->getDynamicFields() instanceof CollectionInterface);
    }
}
