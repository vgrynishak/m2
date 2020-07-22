<?php

namespace App\Tests\Behat\Context\Section\Validator;

use App\App\Command\Section\EditSectionCommand;
use App\App\Command\Section\EditSectionCommandInterface;
use App\App\Command\Section\Validator\EditSectionValidatorInterface;
use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;

class EditSectionValidator implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var bool */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var array */
    private $commandParams = [];
    /** @var EditSectionValidatorInterface */
    private $editSectionValidator;

    /**
     * EditSectionValidator constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param EditSectionValidatorInterface $editSectionValidator
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        EditSectionValidatorInterface $editSectionValidator
    ) {
        $this->editSectionValidator = $editSectionValidator;
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
            'id' => new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba222'),
            'title' => 'change_me',
            'modifiedBy' => $user
        ];
    }

    /**
     * @When I call EditSectionValidator
     */
    public function iCallEditsectionvalidator()
    {
        /** @var EditSectionCommandInterface $editSectionCommand */
        $editSectionCommand = new EditSectionCommand(
            $this->commandParams['id'],
            $this->commandParams['title'],
            $this->commandParams['modifiedBy']
        );

        if ($this->editSectionValidator->validate($editSectionCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->editSectionValidator->getFirstErrorMessage();
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

    /**
     * @param $title
     * @Given Param title is :title
     */
    public function paramTitleIs($title)
    {
        if ($title == 'more_than_256') {
            $this->commandParams['title'] = 'qBRjt6CENy8VzYT4sE0YoxOtp43kftLkFNhjRKo0hYN6IMFupjApaWgTW3lc9WIkx0e0PZPH
            ULuLvIOpXpkQp8dpkcyPiYJWUqWccanNcVURwdsocsen9IQLUB0nyIRaqd0YlVb88p5WRQwDf3xTO1kCP8O2QrPDYHZ5O4hca0kgSZ0YvN
            n5LJNTRphSHoPghHuDXepRZgh4Az9sTp6EMRkKGjal1NMfMyj1eYVWSLVkfVQ31mNAxM7eP8lepGnXl';
        } else {
            $this->commandParams['title'] = $title;
        }
    }
}
