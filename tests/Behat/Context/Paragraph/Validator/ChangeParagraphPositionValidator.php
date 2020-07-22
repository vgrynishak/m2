<?php

namespace App\Tests\Behat\Context\Paragraph\Validator;

use App\App\Command\Paragraph\ChangeParagraphPositionCommand;
use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Command\Paragraph\Validator\ChangeParagraphPositionValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;

class ChangeParagraphPositionValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var array */
    private $commandParams = [];
    /** @var ChangeParagraphPositionValidatorInterface */
    private $changeParagraphPositionValidator;

    /**
     * ChangeParagraphPositionValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ChangeParagraphPositionValidatorInterface $changeParagraphPositionValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ChangeParagraphPositionValidatorInterface $changeParagraphPositionValidator
    ) {
        $this->changeParagraphPositionValidator = $changeParagraphPositionValidator;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @Given I'm set correct command params
     */
    public function imSetCorrectCommandParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->commandParams = [
            'id' => new ParagraphId('63bea125-46f1-4d59-b6ec-13000d13ac9f'),
            'newPosition' => 2,
            'modifiedBy' => $user
        ];
    }

    /**
     * @When I call ChangeParagraphPositionValidator
     */
    public function iCallChangeparagraphpositionvalidator()
    {
        /** @var ChangeParagraphPositionCommandInterface $changeParagraphPositionCommand */
        $changeParagraphPositionCommand = new ChangeParagraphPositionCommand(
            $this->commandParams['id'],
            $this->commandParams['newPosition'],
            $this->commandParams['modifiedBy']
        );

        if ($this->changeParagraphPositionValidator->validate($changeParagraphPositionCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->changeParagraphPositionValidator->getFirstErrorMessage();
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
     * @Given Paragraph with id is not exist
     */
    public function paragraphWithIdIsNotExist()
    {
        $this->commandParams['id'] = new ParagraphId('0f016e65-748f-4d23-9a85-af7d163576b9');
    }

    /**
     * @param $errorMessage
     *
     * @Then I should get message error :errorMessage
     */
    public function iShouldGetMessageError($errorMessage)
    {
        Assert::assertEquals($this->result, $errorMessage);
    }

    /**
     * @param $newPosition
     *
     * @Given Param newPosition is :newPosition
     */
    public function paramNewpositionIs($newPosition)
    {
        $this->commandParams['newPosition'] = $newPosition;
    }

    /**
     * @Given User is not created
     */
    public function userIsNotCreated()
    {
        /** @var UserEntity $userEntity */
        $userEntity = new UserEntity;
        $userEntity->setId(0000000000000);
        /** @var User $user */
        $user = new User($userEntity);
        $this->commandParams['modifiedBy'] = $user;
    }
}
