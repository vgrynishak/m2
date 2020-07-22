<?php

namespace App\Tests\Behat\Context\Service\Validator;

use App\App\Command\Service\CreateServiceCommand as CreateCommand;
use App\App\Command\Service\CreateServiceCommandInterface;
use App\App\Command\Service\Validator\CreateServiceValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use ReflectionClass;
use ReflectionException;

class CreateServiceCommand implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var CreateServiceValidatorInterface */
    private $validator;

    /** @var CreateServiceCommandInterface */
    private $command;

    /** @var array */
    private $errors;

    /** @var bool */
    private $result;

    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;

    /**
     * CreateServiceCommand constructor.
     * @param CreateServiceValidatorInterface $validator
     */
    public function __construct(
        CreateServiceValidatorInterface $validator,
        UserQueryRepositoryInterface $userQueryRepository
    ) {
        $this->validator = $validator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm set correct Command implements CreateServiceCommandInterface
     */
    public function imSetCorrectCommandImplementsCreateservicecommandinterface()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        /** @var CreateServiceCommandInterface command */
        $this->command = new CreateCommand(
            new ServiceId('55e1c758-9aef-4e7c-97d3-0af8637f5868'),
            new DeviceId('04eeff15-d30b-4a28-9c6c-52697c56d161'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            'Test Service Name'
        );

        $this->command->setCreatedBy($user);
        $this->command->setModifiedBy($this->command->getCreatedBy());
    }

    /**
     * @When I call Method Validate
     */
    public function iCallMethodValidate()
    {
        if ($this->command) {
            if ($this->validator->validate($this->command)) {
                $this->result = true;
            } else {
                $this->errors = $this->validator->getErrors();
            }
        }
    }

    /**
     * @Given property ID already exists
     * @throws ReflectionException
     * @throws InvalidServiceIdException
     */
    public function propertyIdAlreadyExists()
    {
        /** @var ReflectionClass $reflectionClass */
        $reflectionClass = new ReflectionClass(CreateCommand::class);
        /** @var ServiceId $newServiceId */
        $newServiceId = new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1');
        $reflectionField = $reflectionClass->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->command, $newServiceId);
    }

    /**
     * @Given property DeviceId not exists
     * @throws ReflectionException
     * @throws InvalidDeviceIdException
     */
    public function propertyDeviceidNotExists()
    {
        /** @var ReflectionClass $reflectionClass */
        $reflectionClass = new ReflectionClass(CreateCommand::class);
        /** @var DeviceId $newDeviceId */
        $newDeviceId = new DeviceId('8e8e10b1-2a9e-4234-b204-8718ce8649af');
        $reflectionField = $reflectionClass->getProperty('deviceId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->command, $newDeviceId);
    }

    /**
     * @Given property FacilityId not exists
     * @throws ReflectionException
     * @throws InvalidFacilityIdException
     */
    public function propertyFacilityidNotExists()
    {
        /** @var ReflectionClass $reflectionClass */
        $reflectionClass = new ReflectionClass(CreateCommand::class);
        /** @var FacilityId $newFacilityId */
        $newFacilityId = new FacilityId('88604363-b250-4872-ac4a-47f2c8ef2608');
        $reflectionField = $reflectionClass->getProperty('facilityId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->command, $newFacilityId);
    }

    /**
     * @Given property Name has length less then 3
     * @throws ReflectionException
     */
    public function propertyNameHasLengthLessThen()
    {
        /** @var ReflectionClass $reflectionClass */
        $reflectionClass = new ReflectionClass(CreateCommand::class);
        $reflectionField = $reflectionClass->getProperty('name');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->command, 'AA');
    }

    /**
     * @Given property Name has length more then 256
     * @throws ReflectionException
     */
    public function propertyNameHasLengthMoreThen()
    {
        /** @var ReflectionClass $reflectionClass */
        $reflectionClass = new ReflectionClass(CreateCommand::class);
        $reflectionField = $reflectionClass->getProperty('name');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->command, str_repeat('test', 75));
    }

    /**
     * @Given user in CreatedBy not exists
     */
    public function userInCreatedbyNotExists()
    {
        $this->command->setCreatedBy($this->wrongUser());
    }

    /**
     * @Given user in ModifiedBy not exists
     */
    public function userInModifiedbyNotExists()
    {
        $this->command->setModifiedBy($this->wrongUser());
    }

    /**
     * @Then I should get true result
     * @throws Exception
     */
    public function iShouldGetTrueResult()
    {
        if (!empty($this->errors)) {
            $errorMessages = implode(PHP_EOL, $this->errors);
            throw new Exception($errorMessages);
        }
    }

    /**
     * @Then I should get message error :arg1
     * @throws Exception
     * @param $message
     */
    public function iShouldGetMessageError($message)
    {
        if (array_search($message, $this->errors) === false) {
            throw new Exception("There is no Exception: '{$message}'");
        }
    }

    private function wrongUser()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        return new User($userEntity);
    }
}
