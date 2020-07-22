<?php

namespace App\Tests\Behat\Context\Paragraph\UseCase;

use App\App\Command\Paragraph\EditParagraphCommand;
use App\App\Command\Paragraph\EditParagraphCommandInterface;
use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\App\UseCase\Paragraph\EditParagraphUseCaseInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class EditParagraphUseCase implements Context
{
    private const USER_ID = 1;
    /** @var EditParagraphUseCaseInterface */
    private $useCase;
    /** @var BaseParagraphInterface */
    private $result;
    /** @var EditParagraphCommandInterface */
    private $command;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * EditParagraphUseCase constructor.
     * @param EditParagraphUseCaseInterface $useCase
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        EditParagraphUseCaseInterface $useCase,
        UserQueryRepositoryInterface $userQueryRepository,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->useCase = $useCase;
        $this->userQueryRepository = $userQueryRepository;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @Given I'm set correct EditParagraphCommand
     */
    public function imSetCorrectEditparagraphcommand()
    {
        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(self::USER_ID);
        /** @var CustomHeaderInterface $header */
        $header = $this->headerFactory->makeCustom('New Test Title');

        $this->command = new EditParagraphCommand(
            new ParagraphId('63bea125-46f1-4d59-b6ec-13000d13ac9f'),
            $header,
            $user
        );
    }

    /**
     * @When I call Method Edit
     */
    public function iCallMethodEdit()
    {
        $this->result = $this->useCase->edit($this->command);
    }

    /**
     * @Then I should get Paragraph implements BaseParagraphInterface
     */
    public function iShouldGetParagraphImplementsBaseparagraphinterface()
    {
        Assert::assertEquals($this->result->getHeader()->getValue(), 'New Test Title');
        Assert::assertEquals($this->result->getModifiedBy()->getId(), self::USER_ID);
    }
}
