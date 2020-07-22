<?php

namespace App\Tests\Behat\Context\Section\Validator;

use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\User\User;
use App\App\Command\Section\DeleteSectionCommand;
use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Command\Section\Validator\DeleteSectionValidatorInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;

class DeleteSectionValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReflectionClass */
    private $reflectionDeleteSectionCommand;
    /** @var DeleteSectionValidatorInterface */
    private $deleteSectionValidator;
    /** @var DeleteSectionCommandInterface */
    private $deleteSectionCommand;

    /**
     * DeleteSectionValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeleteSectionValidatorInterface $deleteSectionValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeleteSectionValidatorInterface $deleteSectionValidator
    ) {
        $this->deleteSectionValidator = $deleteSectionValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidSectionIdException
     *
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->deleteSectionCommand = new DeleteSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba223'),
            $user
        );

        $this->reflectionDeleteSectionCommand = new ReflectionClass($this->deleteSectionCommand);
    }

    /**
     * @When I call DeleteSectionValidator
     */
    public function iCallDeletesectionvalidator()
    {
        if ($this->deleteSectionValidator->validate($this->deleteSectionCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->deleteSectionValidator->getFirstErrorMessage();
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
     * @Given Section with id is not exist
     */
    public function sectionWithIdIsNotExist()
    {
        $reflectionField = $this->reflectionDeleteSectionCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->deleteSectionCommand,
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba111')
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

        $reflectionField = $this->reflectionDeleteSectionCommand->getProperty('modifiedBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->deleteSectionCommand, $user);
    }

    /**
     * @throws InvalidSectionIdException
     * @throws ReflectionException
     * @Given Section contain paragraphs
     */
    public function sectionContainParagraphs()
    {
        $reflectionField = $this->reflectionDeleteSectionCommand->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->deleteSectionCommand,
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba222')
        );
    }
}
