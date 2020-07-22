<?php

namespace App\Tests\Behat\Context\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\EditReportTemplateCommand;
use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\EditReportTemplateValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;

class EditReportTemplateValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var EditReportTemplateValidatorInterface */
    private $editReportTemplateValidator;
    /** @var EditReportTemplateCommandInterface */
    private $editReportTemplateCommand;
    /** @var ReflectionClass */
    private $reflectionEditReportTemplateCommand;

    /**
     * EditReportTemplateValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param EditReportTemplateValidatorInterface $editReportTemplateValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        EditReportTemplateValidatorInterface $editReportTemplateValidator
    ) {
        $this->editReportTemplateValidator = $editReportTemplateValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws InvalidReportTemplateIdException
     * @throws ReflectionException
     *
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->editReportTemplateCommand = new EditReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user,
            'change_me'

        );
        $this->editReportTemplateCommand->setDescription('new description');

        $this->reflectionEditReportTemplateCommand = new ReflectionClass($this->editReportTemplateCommand);
    }

    /**
     * @When I call EditReportTemplateValidator
     */
    public function iCallEditreporttemplatevalidator()
    {
        if ($this->editReportTemplateValidator->validate($this->editReportTemplateCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->editReportTemplateValidator->getFirstErrorMessage();
        }
    }

    /**
     * @throws Exception
     *
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
     * @Given ReportTemplate with id is not exist
     */
    public function reporttemplateWithIdIsNotExist()
    {
        $reflectionField = $this->reflectionEditReportTemplateCommand->getProperty('reportTemplateId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->editReportTemplateCommand,
            new ReportTemplateId('0f016e65-748f-4d23-9a85-af7d163576b9')
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
     * @throws InvalidReportTemplateIdException
     * @throws ReflectionException
     * @Given Status is invalid for this action
     */
    public function statusIsInvalidForThisAction()
    {
        $reflectionField = $this->reflectionEditReportTemplateCommand->getProperty('reportTemplateId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->editReportTemplateCommand,
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba240')
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

        $reflectionField = $this->reflectionEditReportTemplateCommand->getProperty('modifiedBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->editReportTemplateCommand, $user);
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @throws ReflectionException
     * @Given Param :paramName is :paramValue
     */
    public function paramNameIs($paramName, $paramValue)
    {
        $reflectionField = $this->reflectionEditReportTemplateCommand->getProperty($paramName);
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->editReportTemplateCommand, $paramValue);
    }
}
