<?php

namespace App\Tests\Behat\Context\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\PublishReportTemplateCommand;
use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\PublishReportTemplateValidatorInterface;
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

class PublishReportTemplateValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReflectionClass */
    private $reflectionPublishReportTemplateCommand;
    /** @var PublishReportTemplateValidatorInterface */
    private $publishReportTemplateValidator;
    /** @var PublishReportTemplateCommandInterface */
    private $publishReportTemplateCommand;

    /**
     * PublishReportTemplateValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param PublishReportTemplateValidatorInterface $publishReportTemplateValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        PublishReportTemplateValidatorInterface $publishReportTemplateValidator
    ) {
        $this->publishReportTemplateValidator = $publishReportTemplateValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidReportTemplateIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->publishReportTemplateCommand = new PublishReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user
        );

        $this->reflectionPublishReportTemplateCommand = new ReflectionClass($this->publishReportTemplateCommand);
    }

    /**
     * @When I call PublishReportTemplateValidator
     */
    public function iCallPublishreporttemplatevalidator()
    {
        if ($this->publishReportTemplateValidator->validate($this->publishReportTemplateCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->publishReportTemplateValidator->getFirstErrorMessage();
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
     * @Given ReportTemplate with id is not exist
     */
    public function reporttemplateWithIdIsNotExist()
    {
        $reflectionField = $this->reflectionPublishReportTemplateCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->publishReportTemplateCommand,
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
        $reflectionField = $this->reflectionPublishReportTemplateCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->publishReportTemplateCommand,
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

        $reflectionField = $this->reflectionPublishReportTemplateCommand->getProperty('user');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->publishReportTemplateCommand, $user);
    }
}
