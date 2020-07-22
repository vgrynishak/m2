<?php

namespace App\Tests\Behat\Context\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\CreateReportTemplateCommand;
use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\CreateReportTemplateValidatorInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;
use App\App\Doctrine\Entity\User as UserEntity;

class CreateReportTemplateValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateReportTemplateValidatorInterface */
    private $createReportTemplateValidator;
    /** @var CreateReportTemplateCommandInterface */
    private $createReportTemplateCommand;
    /** @var ReflectionClass */
    private $reflectionCreateReportTemplateCommand;

    /**
     * CreateReportTemplateValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param CreateReportTemplateValidatorInterface $createReportTemplateValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        CreateReportTemplateValidatorInterface $createReportTemplateValidator
    ) {
        $this->createReportTemplateValidator = $createReportTemplateValidator;
        $this->userQueryRepository = $userQueryRepository;
    }


    /**
     * @throws InvalidDeviceIdException
     * @throws InvalidReportTemplateIdException
     * @throws InvalidServiceIdException
     * @throws ReflectionException
     *
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createReportTemplateCommand = new CreateReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba220'),
            new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'),
            new ServiceId('63bea125-46f1-4d59-b6ec-65000d13acc1'),
            'new_rt_name'
        );
        $this->createReportTemplateCommand->setDescription('new description');
        $this->createReportTemplateCommand->setCreatedBy($user);

        $this->reflectionCreateReportTemplateCommand = new ReflectionClass($this->createReportTemplateCommand);
    }

    /**
     * @When I call CreateReportTemplateValidator
     */
    public function iCallCreatereporttemplatevalidator()
    {
        if ($this->createReportTemplateValidator->validate($this->createReportTemplateCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->createReportTemplateValidator->getFirstErrorMessage();
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
     * @throws InvalidReportTemplateIdException
     * @throws ReflectionException
     * @Given ReportTemplate with id is already exist
     */
    public function reporttemplateWithIdIsAlreadyExist()
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createReportTemplateCommand,
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
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
            $this->createReportTemplateCommand,
            new ServiceId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        );
    }

    /**
     * @throws InvalidDeviceIdException
     * @throws ReflectionException
     * @Given Device is not exist
     */
    public function deviceIsNotExist()
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('deviceId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createReportTemplateCommand,
            new DeviceId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        );
    }

    /**
     * @throws ReflectionException
     * @Given User is not created
     */
    public function userIsNotCreated()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        $user = new User($userEntity);

        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('createdBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createReportTemplateCommand, $user);
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @throws ReflectionException
     * @Given Param :paramName is :paramValue
     */
    public function paramNameIs($paramName, $paramValue)
    {
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty($paramName);
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createReportTemplateCommand, $paramValue);
    }
}
