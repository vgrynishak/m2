<?php

namespace App\Tests\Behat\Context\Section\Validator;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Command\Section\CreateSectionCommandInterface;
use App\App\Command\Section\Validator\CreateSectionValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;

class CreateSectionValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var CreateSectionValidatorInterface */
    private $createSectionValidator;
    /** @var CreateSectionCommandInterface */
    private $createSectionCommand;
    /** @var ReflectionClass */
    private $reflectionCreateSectionCommand;

    /**
     * CreateSectionValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param CreateSectionValidatorInterface $createSectionValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        CreateSectionValidatorInterface $createSectionValidator
    ) {
        $this->createSectionValidator = $createSectionValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws InvalidReportTemplateIdException
     * @throws InvalidSectionIdException
     * @throws ReflectionException
     *
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->createSectionCommand = new CreateSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba220'),
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            'title'
        );
        $this->createSectionCommand->setCreatedBy($user);

        $this->reflectionCreateSectionCommand = new ReflectionClass($this->createSectionCommand);
    }

    /**
     * @When I call CreateSectionValidator
     */
    public function iCallCreatesectionvalidator()
    {
        if ($this->createSectionValidator->validate($this->createSectionCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->createSectionValidator->getFirstErrorMessage();
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
     * @throws InvalidSectionIdException
     * @throws ReflectionException
     * @Given Section with id is already exist
     */
    public function sectionWithIdIsAlreadyExist()
    {
        $reflectionField = $this->reflectionCreateSectionCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createSectionCommand,
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba222')
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
     * @Given ReportTemplate is not exist
     */
    public function reporttemplateIsNotExist()
    {
        $reflectionField = $this->reflectionCreateSectionCommand->getProperty('reportTemplateId');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createSectionCommand,
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba222')
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

        $reflectionField = $this->reflectionCreateSectionCommand->getProperty('createdBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createSectionCommand, $user);
    }

    /**
     * @param $title
     * @throws ReflectionException
     * @Given Param :title small
     */
    public function paramSmall($title)
    {
        $reflectionField = $this->reflectionCreateSectionCommand->getProperty($title);
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->createSectionCommand, 'ti');
    }

    /**
     * @param $title
     * @throws ReflectionException
     * @Given Param :title large
     */
    public function paramLarge($title)
    {
        $reflectionField = $this->reflectionCreateSectionCommand->getProperty($title);
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->createSectionCommand,
            '6O2kqgPrJh48BVlmGPrDKVdTheL6yCoL0FVzIY4fb41cB7SAayY5ONnaobziOmuZvt0Wir2qk8ACFN0McPdgKj1z0T739hPWG10m
            BkFSbDcX80Zj9OrE6a14q0yt4lEm5AgPGzQN1zrXi5JXp0vRV3RT1ttIazDHk3NjwFwzkVajg4dQUTUatzGmqxs4ae4KBJPRLejNLsT91f6
            xOtAV1xx8aPxftVDevnTjDTl7dot74t38omZVWoKo7fVFmYSzR6O2kqgPrJh48BVlmGPrDKVdTheL6yCoL0FVzIY4fb41cB7SAayY5ONnao
            bziOmuZvt0Wir2qk8ACFN0McPdgKj1z0T739hPWG10mBkFSbDcX80Zj9OrE6a14q0yt4lEm5AgPGzQN1zrXi5JXp0vRV3RT1ttIazDHk3Njw
            FwzkVajg4dQUTUatzGmqxs4ae4KBJPRLejNLsT91f6xOtAV1xx8aPxftVDevnTjDTl7dot74t38omZVWoKo7fVFmYSzR'
        );
    }
}
