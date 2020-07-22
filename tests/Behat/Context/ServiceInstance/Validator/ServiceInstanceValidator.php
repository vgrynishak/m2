<?php

namespace App\Tests\Behat\Context\ServiceInstance\Validator;

use App\App\Command\ServiceInstance\CreateServiceInstanceCommand;
use App\App\Command\ServiceInstance\CreateServiceInstanceCommandInterface;
use App\App\Command\ServiceInstance\Validator\CreateServiceInstanceValidatorInterface;
use App\Core\Model\Exception\InvalidFacilityIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\Exception\InvalidServiceInstanceIdException;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;
use App\App\Doctrine\Entity\User as UserEntity;

class ServiceInstanceValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateServiceInstanceValidatorInterface */
    private $createServiceInstanceValidator;
    /** @var CreateServiceInstanceCommandInterface */
    private $createServiceInstanceCommand;
    /** @var ReflectionClass */
    private $reflectionCreateReportTemplateCommand;

    /**
     * ServiceInstanceValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param CreateServiceInstanceValidatorInterface $createServiceInstanceValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        CreateServiceInstanceValidatorInterface $createServiceInstanceValidator
    ) {
        $this->createServiceInstanceValidator = $createServiceInstanceValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidFacilityIdException
     * @throws InvalidServiceIdException
     * @throws InvalidServiceInstanceIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createServiceInstanceCommand = new CreateServiceInstanceCommand(
            new ServiceInstanceId('6c614218-3ead-11ea-b77f-2e728ce88124'),
            new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1'),
            new FacilityId('b0930100-cde5-4318-8d65-0313bae92aa9'),
            $user
        );

        $this->reflectionCreateReportTemplateCommand = new ReflectionClass($this->createServiceInstanceCommand);
    }

    /**
     * @When I call CreateServiceInstanceValidator
     */
    public function iCallCreateserviceinstancevalidator()
    {
        if ($this->createServiceInstanceValidator->validate($this->createServiceInstanceCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->createServiceInstanceValidator->getFirstErrorMessage();
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
     * @throws InvalidServiceInstanceIdException
     * @throws ReflectionException
     * @Given ServiceInstance with id is already exist
     */
    public function serviceinstanceWithIdIsAlreadyExist()
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createServiceInstanceCommand,
            new ServiceInstanceId('6c614218-3ead-11ea-b77f-2e728ce88125')
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
     * @throws InvalidServiceIdException
     * @throws ReflectionException
     * @Given Service is not exist
     */
    public function serviceIsNotExist()
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('serviceId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createServiceInstanceCommand,
            new ServiceId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        );
    }

    /**
     * @throws InvalidFacilityIdException
     * @throws ReflectionException
     * @Given Facility is not exist
     */
    public function facilityIsNotExist()
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('facilityId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createServiceInstanceCommand,
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

        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('createdBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createServiceInstanceCommand, $user);
    }
}
