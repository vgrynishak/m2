<?php

namespace App\Tests\Behat\Context\Paragraph\CommandRepository;

use App\App\Factory\Paragraph\HeaderFactoryInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\User\UserInterface;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class EditParagraph implements Context
{
    private const USER_ID = 1;
    private const TEST_TITLE = 'New Test Title string';

    /** @var Connection */
    private $doctrineConnection;
    /** @var BaseParagraphInterface */
    private $paragraphModel;
    /** @var ParagraphCommandRepositoryInterface */
    private $commandRepository;
    /** @var ParagraphQueryRepositoryInterface */
    private $queryRepository;
    /** @var UserQueryRepositoryInterface */
    private $userQueryRepository;
    /** @var BaseParagraphInterface */
    private $result;
    /** @var DateTime */
    private $date;
    /** @var HeaderFactoryInterface */
    private $headerFactory;

    /**
     * EditParagraph constructor.
     * @param ParagraphCommandRepositoryInterface $commandRepository
     * @param ParagraphQueryRepositoryInterface $queryRepository
     * @param UserQueryRepositoryInterface $userQueryRepository
     * @param Connection $connection
     * @param HeaderFactoryInterface $headerFactory
     */
    public function __construct(
        ParagraphCommandRepositoryInterface $commandRepository,
        ParagraphQueryRepositoryInterface $queryRepository,
        UserQueryRepositoryInterface $userQueryRepository,
        Connection $connection,
        HeaderFactoryInterface $headerFactory
    ) {
        $this->commandRepository = $commandRepository;
        $this->queryRepository = $queryRepository;
        $this->userQueryRepository = $userQueryRepository;
        $this->doctrineConnection = $connection;
        $this->headerFactory = $headerFactory;
    }

    /**
     * @param string $id
     * @throws InvalidParagraphIdException
     */
    private function findParagraphModel(string $id)
    {
        $this->date = new DateTime();

        /** @var UserInterface $user */
        $user = $this->userQueryRepository->find(self::USER_ID);
        /** @var CustomHeaderInterface $header */
        $header = $this->headerFactory->makeCustom(self::TEST_TITLE);

        $this->paragraphModel = $this->queryRepository->find(new ParagraphId($id));
        $this->paragraphModel->setHeader($header);
        $this->paragraphModel->setModifiedBy($user);
        $this->paragraphModel->setUpdatedAt($this->date);
    }

    /**
     * @When I Call Method Update
     * @throws ConnectionException
     * @throws InvalidParagraphIdException
     */
    public function iCallMethodUpdate()
    {
        $this->doctrineConnection->beginTransaction();
        $this->commandRepository->update($this->paragraphModel);
        $this->result = $this->queryRepository->find($this->paragraphModel->getId());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get updated data
     */
    public function iShouldGetUpdatedData()
    {
        Assert::assertEquals($this->result->getModifiedBy()->getId(), self::USER_ID);
        Assert::assertEquals($this->result->getUpdatedAt(), $this->date);
        Assert::assertEquals($this->result->getHeader()->getValue(), self::TEST_TITLE);
    }

    /**
     * @Given I'm Set correct RootParagraphWithoutDevice model
     * @throws InvalidParagraphIdException
     */
    public function imSetCorrectRootparagraphwithoutdeviceModel()
    {
        $this->findParagraphModel('63bea125-46f1-4d59-b6ec-13000d13ac9f');
    }

    /**
     * @Given I'm Set correct RootParagraphWithDevice model
     * @throws InvalidParagraphIdException
     */
    public function imSetCorrectRootparagraphwithdeviceModel()
    {
        $this->findParagraphModel('ac0cec75-b17d-4509-b15a-29621c41b17d');
    }

    /**
     * @Given I'm Set correct ChildParagraphWithDevice model
     * @throws InvalidParagraphIdException
     */
    public function imSetCorrectChildparagraphwithdeviceModel()
    {
        $this->findParagraphModel('63bea125-46f1-4d59-b6ec-13010d13ac9f');
    }
}
