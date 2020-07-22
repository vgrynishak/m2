<?php

namespace App\Tests\Behat\Context\Device\Validator;

use App\App\Command\Device\CreateDeviceCommand;
use App\App\Command\Device\CreateDeviceCommandInterface;
use App\App\Command\Device\Validator\CreateDeviceValidatorInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDivisionIdException;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;
use App\App\Doctrine\Entity\User as UserEntity;

class DeviceValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateDeviceValidatorInterface */
    private $createDeviceValidator;
    /** @var CreateDeviceCommandInterface */
    private $createDeviceCommand;
    /** @var ReflectionClass */
    private $reflectionCommand;

    /**
     * DeviceValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param CreateDeviceValidatorInterface $createDeviceValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        CreateDeviceValidatorInterface $createDeviceValidator
    ) {
        $this->createDeviceValidator = $createDeviceValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidDeviceIdException
     * @throws InvalidDivisionIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createDeviceCommand = new CreateDeviceCommand(
            new DeviceId('872de578-41c9-11ea-b77f-2e728ce88125'),
            "name",
            new DivisionId('95f79e37-b4f3-4402-a946-64a33fe509b3'),
            5,
            'alias',
            $user
        );
        $this->createDeviceCommand->setParentId(new DeviceId('96f3b5e6-c98c-45bd-9f6e-05d6ff3577fe'));

        $this->reflectionCommand = new ReflectionClass($this->createDeviceCommand);
    }

    /**
     * @When I call CreateDeviceValidator
     */
    public function iCallCreatedevicevalidator()
    {
        if ($this->createDeviceValidator->validate($this->createDeviceCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->createDeviceValidator->getFirstErrorMessage();
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
     * @throws InvalidDeviceIdException
     * @throws ReflectionException
     * @Given Device with id is already exist
     */
    public function deviceWithIdIsAlreadyExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceCommand,
            new DeviceId('96f3b5e6-c98c-45bd-9f6e-05d6ff3577fe')
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
        $reflectionField->setValue($this->createDeviceCommand, $user);
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws ReflectionException
     * @Given Parent is not exist
     */
    public function parentIsNotExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('parentId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceCommand,
            new DeviceId('96f3b5e6-c98c-45bd-9f6e-05d6ff357fff')
        );
    }

    /**
     * @throws InvalidDivisionIdException
     * @throws ReflectionException
     * @Given Division is not exist
     */
    public function divisionIsNotExist()
    {
        $reflectionField = $this->reflectionCommand->getProperty('divisionId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createDeviceCommand,
            new DivisionId('96f3b5e6-c98c-45bd-9f6e-05d6ff357fff')
        );
    }

    /**
     * @param $name
     * @throws ReflectionException
     * @Given Param name is :name
     */
    public function paramNameIs($name)
    {
        if ($name == 'more_than_256') {
            $name = 'qBRjt6CENy8VzYT4sE0YoxOtp43kftLkFNhjRKo0hYN6IMFupjApaWgTW3lc9WIkx0e0PZPH
            ULuLvIOpXpkQp8dpkcyPiYJWUqWccanNcVURwdsocsen9IQLUB0nyIRaqd0YlVb88p5WRQwDf3xTO1kCP8O2QrPDYHZ5O4hca0kgSZ0YvN
            n5LJNTRphSHoPghHuDXepRZgh4Az9sTp6EMRkKGjal1NMfMyj1eYVWSLVkfVQ31mNAxM7eP8lepGnXl';
        }

        $reflectionField = $this->reflectionCommand->getProperty('name');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createDeviceCommand, $name);
    }

    /**
     * @param $alias
     * @throws ReflectionException
     * @Given Param alias is :alias
     */
    public function paramAliasIs($alias)
    {
        if ($alias == 'more_than_256') {
            $alias = 'qBRjt6CENy8VzYT4sE0YoxOtp43kftLkFNhjRKo0hYN6IMFupjApaWgTW3lc9WIkx0e0PZPH
            ULuLvIOpXpkQp8dpkcyPiYJWUqWccanNcVURwdsocsen9IQLUB0nyIRaqd0YlVb88p5WRQwDf3xTO1kCP8O2QrPDYHZ5O4hca0kgSZ0YvN
            n5LJNTRphSHoPghHuDXepRZgh4Az9sTp6EMRkKGjal1NMfMyj1eYVWSLVkfVQ31mNAxM7eP8lepGnXl';
        }

        $reflectionField = $this->reflectionCommand->getProperty('alias');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createDeviceCommand, $alias);
    }

    /**
     * @param $level
     * @throws ReflectionException
     * @Given Param level is :level
     */
    public function paramLevelIs($level)
    {
        $reflectionField = $this->reflectionCommand->getProperty('level');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createDeviceCommand, $level);
    }
}
