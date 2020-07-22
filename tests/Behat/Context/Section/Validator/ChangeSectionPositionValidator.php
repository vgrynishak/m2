<?php

namespace App\Tests\Behat\Context\Section\Validator;

use App\App\Command\Section\ChangeSectionPositionCommand;
use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\App\Command\Section\Validator\ChangeSectionPositionValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;

class ChangeSectionPositionValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var array */
    private $commandParams = [];
    /** @var ChangeSectionPositionValidatorInterface */
    private $changeSectionPositionValidator;

    /**
     * ChangeSectionPositionValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param ChangeSectionPositionValidatorInterface $changeSectionPositionValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        ChangeSectionPositionValidatorInterface $changeSectionPositionValidator
    ) {
        $this->changeSectionPositionValidator = $changeSectionPositionValidator;
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
            'id' => new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba228'),
            'newPosition' => 2,
            'modifiedBy' => $user
        ];
    }

    /**
     * @When I call ChangeSectionPositionValidator
     */
    public function iCallChangesectionpositionvalidator()
    {
        /** @var ChangeSectionPositionCommandInterface $changeSectionPositionCommand */
        $changeSectionPositionCommand = new ChangeSectionPositionCommand(
            $this->commandParams['id'],
            $this->commandParams['newPosition'],
            $this->commandParams['modifiedBy']
        );

        if ($this->changeSectionPositionValidator->validate($changeSectionPositionCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->changeSectionPositionValidator->getFirstErrorMessage();
        }
    }

    /**
     * @Then I should get true result
     * @throws Exception
     */
    public function iShouldGetNextPositiveResult()
    {
        if (!empty($this->errors)) {
            $errorMessages = implode(PHP_EOL, $this->errors);
            throw new Exception($errorMessages);
        }
    }

    /**
     * @Given Section with id is not exist
     */
    public function sectionWithIdIsNotExist()
    {
        $this->commandParams['id'] = new SectionId('0f016e65-748f-4d23-9a85-af7d163576b9');
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
     * @param $newPosition
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
