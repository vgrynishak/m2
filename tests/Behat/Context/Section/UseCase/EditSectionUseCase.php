<?php

namespace App\Tests\Behat\Context\Section\UseCase;

use App\App\Command\Section\EditSectionCommand;
use App\App\Command\Section\EditSectionCommandInterface;
use App\App\UseCase\Section\EditSectionUseCaseInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class EditSectionUseCase implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var SectionInterface */
    private $result;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var EditSectionCommandInterface */
    private $editSectionCommand;
    /** @var EditSectionUseCaseInterface */
    private $editSectionUseCase;

    /**
     * EditSectionUseCase constructor.
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param EditSectionUseCaseInterface $editSectionUseCase
     */
    public function __construct(
        UserQueryRepositoryInterface $userQueryRepository,
        EditSectionUseCaseInterface $editSectionUseCase
    ) {
        $this->userQueryRepository = $userQueryRepository;
        $this->editSectionUseCase = $editSectionUseCase;
    }

    /**
     * @Given I'm set EditSectionCommandInterface with correct params
     */
    public function imSetCorrectUseCaseParams()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->findByUsername(self::ADMIN_USER_EMAIL);

        $this->editSectionCommand = new EditSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba222'),
            'change_me',
            $user
        );
    }

    /**
     * @When I call EditSectionUseCase
     */
    public function iCallEditsectionusecase()
    {
        $this->result = $this->editSectionUseCase->edit($this->editSectionCommand);
    }

    /**
     * @Then I should get SectionInterface with edited params
     */
    public function iShouldGetSectioninterfaceWithEditedParams()
    {
        Assert::assertEquals($this->result->getTitle(), $this->editSectionCommand->getTitle());
        Assert::assertEquals($this->result->getModifiedBy(), $this->editSectionCommand->getModifiedBy());
    }
}
