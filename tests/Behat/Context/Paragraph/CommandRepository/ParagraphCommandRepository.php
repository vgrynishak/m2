<?php

namespace App\Tests\Behat\Context\Paragraph\CommandRepository;

use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Paragraph\ParagraphCommandRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PHPUnit\Framework\Assert;

class ParagraphCommandRepository implements Context
{
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var BaseParagraphInterface */
    private $paragraph;
    /** @var BaseParagraphInterface | null */
    private $result;
    /** @var ParagraphCommandRepositoryInterface */
    private $paragraphCommandRepository;
    /** @var Connection */
    private $doctrineConnection;

    /**
     * ParagraphCommandRepository constructor.
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param ParagraphCommandRepositoryInterface $paragraphCommandRepository
     * @param Connection $connection
     */
    public function __construct(
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        ParagraphCommandRepositoryInterface $paragraphCommandRepository,
        Connection $connection
    ) {
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->paragraphCommandRepository = $paragraphCommandRepository;
        $this->doctrineConnection = $connection;
    }

    /**
     * @Given I'm find BaseParagraphInterface which I want to delete
     */
    public function imFindParagraphinterfaceWhichIWantToDelete()
    {
        $this->paragraph =
            $this->paragraphQueryRepository->find(new ParagraphId('63bea125-46f1-4d59-b6ec-13008d13ac9f'));
    }

    /**
     * @throws ConnectionException
     * @throws InvalidParagraphIdException
     * @When I Call Method Delete
     */
    public function iCallMethodDelete()
    {
        $this->doctrineConnection->beginTransaction();

        $this->paragraphCommandRepository->delete($this->paragraph);
        $this->result = $this->paragraphQueryRepository->find(new ParagraphId('63bea125-46f1-4d59-b6ec-13008d13ac9f'));
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should not get this Paragraph
     */
    public function iShouldNotGetThisParagraph()
    {
        Assert::assertEquals($this->result instanceof BaseParagraphInterface, false);
    }
}
