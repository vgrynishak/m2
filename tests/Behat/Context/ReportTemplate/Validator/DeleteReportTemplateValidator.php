<?php

namespace App\Tests\Behat\Context\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\DeleteReportTemplateCommand;
use App\App\Command\ReportTemplate\DeleteReportTemplateCommandInterface;
use App\App\Command\ReportTemplate\Validator\DeleteReportTemplateValidatorInterface;
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

class DeleteReportTemplateValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReflectionClass */
    private $reflectionCreateReportTemplateCommand;
    /** @var DeleteReportTemplateValidatorInterface */
    private $deleteReportTemplateValidator;
    /** @var DeleteReportTemplateCommandInterface */
    private $deleteReportTemplateCommand;

    /**
     * DeleteReportTemplateValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeleteReportTemplateValidatorInterface $deleteReportTemplateValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeleteReportTemplateValidatorInterface $deleteReportTemplateValidator
    ) {
        $this->deleteReportTemplateValidator = $deleteReportTemplateValidator;
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

        $this->deleteReportTemplateCommand = new DeleteReportTemplateCommand(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            $user
        );

        $this->reflectionCreateReportTemplateCommand = new ReflectionClass($this->deleteReportTemplateCommand);
    }

    /**
     * @When I call DeleteReportTemplateValidator
     */
    public function iCallDeletereporttemplatevalidator()
    {
        if ($this->deleteReportTemplateValidator->validate($this->deleteReportTemplateCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->deleteReportTemplateValidator->getFirstErrorMessage();
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
        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->deleteReportTemplateCommand,
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba333')
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
     * @Given User is not created
     */
    public function userIsNotCreated()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        $user = new User($userEntity);

        $reflectionField = $this->reflectionCreateReportTemplateCommand->getProperty('user');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->deleteReportTemplateCommand, $user);
    }
}
