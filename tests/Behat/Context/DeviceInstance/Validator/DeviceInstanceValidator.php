<?php

namespace App\Tests\Behat\Context\DeviceInstance\Validator;

use App\App\Command\DeviceInstance\CreateDeviceInstanceCommand;
use App\App\Command\DeviceInstance\CreateDeviceInstanceCommandInterface;
use App\App\Command\DeviceInstance\Validator\CreateDeviceInstanceValidatorInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDeviceInstanceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;
use App\App\Doctrine\Entity\User as UserEntity;

class DeviceInstanceValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateDeviceInstanceValidatorInterface */
    private $createDeviceInstanceValidator;
    /** @var CreateDeviceInstanceCommandInterface */
    private $createDeviceInstanceCommand;
    /** @var ReflectionClass */
    private $reflectionCommand;

    /**
     * DeviceInstanceValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param CreateDeviceInstanceValidatorInterface $createDeviceInstanceValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        CreateDeviceInstanceValidatorInterface $createDeviceInstanceValidator
    ) {
        $this->createDeviceInstanceValidator = $createDeviceInstanceValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidDeviceIdException
     * @throws InvalidDeviceInstanceIdException
     * @throws InvalidFacilityIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createDeviceInstanceCommand = new CreateDeviceInstanceCommand(
            new DeviceInstanceId('f1d144f4-3c30-11ea-b77f-2e728ce88126'),
            new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            $user
        );
        $this->createDeviceInstanceCommand->setParentId(new DeviceInstanceId('f1d144f4-3c30-11ea-b77f-2e728ce88125'));

        $this->reflectionCommand = new ReflectionClass($this->createDeviceInstanceCommand);
    }

    /**
     * @When I call CreateDeviceInstanceValidator
     */
    public function iCallCreatedeviceinstancevalidator()
    {
        if ($this->createDeviceInstanceValidator->validate($this->createDeviceInstanceCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->createDeviceInstanceValidator->getFirstErrorMessage();
        }
    }

    /**
     * @throws Exception
     * @Then I should get true result
     */
    public function iShouldGetTrueResult()
    {
        if (!empty($this->errors)) {
            $errorMessages = implode(PHP_EOL, $this->errors);
            throw new Exception($errorMessages);
        }
    }

    /**
     * @throws InvalidDeviceInstanceIdException
     * @throws ReflectionException
     * @Given DeviceInstance with id is already exist
     */
    public function deviceinstanceWithIdIsAlreadyExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceInstanceCommand,
            new DeviceInstanceId('f1d144f4-3c30-11ea-b77f-2e728ce88125')
        );
    }

    /**
     * @param $errorMessage
     * @Then I should get message error :errorMessage
     */
    public function iShouldGetMessageError($errorMessage)
    {
        Assert::assertEquals($this->result, $errorMessage);
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws ReflectionException
     * @Given Device is not exist
     */
    public function deviceIsNotExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('deviceId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceInstanceCommand,
            new DeviceId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        );
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws ReflectionException
     * @Given Facility is not exist
     */
    public function facilityIsNotExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('facilityId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceInstanceCommand,
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa8')
        );
    }

    /**
     * @throws ReflectionException
     * @Given User is not exist
     */
    public function userIsNotExist()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        $user = new User($userEntity);

        $reflectionField = $this->reflectionCommand->getProperty('createdBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createDeviceInstanceCommand, $user);
    }

    /**
     * @throws InvalidDeviceInstanceIdException
     * @throws ReflectionException
     * @Given Parent is not exist
     */
    public function parentIsNotExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('parentId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceInstanceCommand,
            new DeviceInstanceId('b0930100-cde5-4318-8d65-0313bae92aa8')
        );
    }
}
