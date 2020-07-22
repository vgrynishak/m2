<?php

namespace App\Tests\Behat\Context\Paragraph\Validator;

use App\App\Command\Paragraph\DeleteParagraphCommand;
use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Command\Paragraph\Validator\DeleteParagraphValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionException;

class DeleteParagraphValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var ReflectionClass */
    private $reflectionClass;
    /** @var DeleteParagraphValidatorInterface */
    private $deleteValidator;
    /** @var DeleteParagraphCommandInterface */
    private $deleteCommand;

    /**
     * DeleteParagraphValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param DeleteParagraphValidatorInterface $deleteValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        DeleteParagraphValidatorInterface $deleteValidator
    ) {
        $this->deleteValidator = $deleteValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidParagraphIdException
     * @Given I'm set correct command
     */
    public function imSetCorrectCommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->deleteCommand = new DeleteParagraphCommand(
            new ParagraphId('63bea125-46f1-4d59-b6ec-13008d13ac9f'),
            $user
        );

        $this->reflectionClass = new ReflectionClass($this->deleteCommand);
    }

    /**
     * @When I call DeleteParagraphValidator
     */
    public function iCallDeleteparagraphvalidator()
    {
        if ($this->deleteValidator->validate($this->deleteCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->deleteValidator->getFirstErrorMessage();
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
     * @throws InvalidParagraphIdException
     * @throws ReflectionException
     * @Given Paragraph with id is not exist
     */
    public function paragraphWithIdIsNotExist()
    {
        $reflectionField = $this->reflectionClass->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->deleteCommand,
            new ParagraphId('e9658062-47fe-11ea-b77f-2e728ce88125')
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

        $reflectionField = $this->reflectionClass->getProperty('modifiedBy');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue($this->deleteCommand, $user);
    }

    /**
     * @throws InvalidParagraphIdException
     * @throws ReflectionException
     * @Given Paragraph contain children
     */
    public function paragraphContainChildren()
    {
        $reflectionField = $this->reflectionClass->getProperty('id');
        $reflectionField->setAccessible(true);
        $reflectionField->setValue(
            $this->deleteCommand,
            new ParagraphId('ac0cec75-b17d-4509-b15a-29621c41b17d')
        );
    }
}
