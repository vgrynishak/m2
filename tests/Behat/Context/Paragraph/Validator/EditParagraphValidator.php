<?php

namespace App\Tests\Behat\Context\Paragraph\Validator;

use App\App\Command\Paragraph\EditParagraphCommand;
use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Command\Paragraph\Validator\EditParagraphValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;

class EditParagraphValidator implements Context
{
    private const USER_ID = 1;

    /** @var bool */
    private $result;
    /** @var EditParagraphValidatorInterface */
    private $validator;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var EditParagraphCommandInterface */
    private $command;
    /** @var UserInterface */
    private $user;
    /** @var array */
    private $errors = [];
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * EditParagraphValidator constructor.
     * @param EditParagraphValidatorInterface $validator
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        EditParagraphValidatorInterface $validator,
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->validator = $validator;
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param string $id
     * @param string $title
     * @throws InvalidParagraphIdException
     */
    private function createCommand(string $id, string $title)
    {
        /** @var CustomHeaderInterface $header */
        $header = $this->headerFactory->makeCustom($title);

        $this->command = new EditParagraphCommand(
            new ParagraphId($id),
            $header,
            $this->user
        );
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
     * @Then I should get message error :message
     * @param $message
     * @throws Exception
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

    /**
     * @Given I'm set correct EditParagraphCommand
     * @throws InvalidParagraphIdException
     */
    public function imSetCorrectEditparagraphcommand()
    {
        /** @var UserInterface $user */
        $this->user = $this->userQueryRepository->find(self::USER_ID);

        $this->createCommand('63bea125-46f1-4d59-b6ec-13000d13ac9f', 'New Title');
    }

    /**
     * @Given I'm set EditParagraphCommand with Title less then 3
     * @throws InvalidParagraphIdException
     */
    public function imSetEditparagraphcommandWithTitleLessThen()
    {
        /** @var UserInterface $user */
        $this->user = $this->wrongUser();

        $this->createCommand('63bea125-46f1-4d59-b6ec-13000d13ac9f', 'AA');
    }

    /**
     * @Given I'm set EditParagraphCommand with Title greater then 100
     * @throws InvalidParagraphIdException
     */
    public function imSetEditparagraphcommandWithTitleGreaterThen()
    {
        $stringOver100characters = 'VweryLooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
        oooooooooooooooooooooooooooooooooooooongString';

        /** @var UserInterface $user */
        $this->user = $this->wrongUser();

        $this->createCommand('63bea125-46f1-4d59-b6ec-13000d13ac9f', $stringOver100characters);
    }

    /**
     * @Given I'm set EditParagraphCommand with not exists Id
     * @throws InvalidParagraphIdException
     */
    public function imSetEditparagraphcommandWithNotExistsId()
    {
        /** @var UserInterface $user */
        $this->user = $this->userQueryRepository->find(self::USER_ID);

        $this->createCommand('713d0732-1719-49aa-959c-f1288dd87cf2', 'New Title');
    }

    /**
     * @Given I'm set EditParagraphCommand with not created User
     * @throws InvalidParagraphIdException
     */
    public function imSetEditparagraphcommandWithNotCreatedUser()
    {
        /** @var UserInterface $user */
        $this->user = $this->wrongUser();

        $this->createCommand('63bea125-46f1-4d59-b6ec-13000d13ac9f', 'New Title');
    }
}
