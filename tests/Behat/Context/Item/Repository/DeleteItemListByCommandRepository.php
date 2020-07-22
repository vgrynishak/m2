<?php

namespace App\Tests\Behat\Context\Item\Repository;

use App\App\Factory\Exception\FailMakeItemModel;
use App\Core\Model\Exception\InvalidItemIdException;
use App\Core\Model\Exception\InvalidItemTypeIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class DeleteItemListByCommandRepository implements Context
{
    /** @var ItemQueryRepositoryInterface */
    private $itemQueryRepository;
    /** @var ItemCommandRepositoryInterface */
    private $itemCommandRepository;
    /** @var CollectionInterface | null */
    private $result;
    /** @var CollectionInterface */
    private $items;
    /** @var Connection */
    private $doctrineConnection;

    /**
     * DeleteItemListByCommandRepository constructor.
     * @param Connection $connection
     * @param ItemQueryRepositoryInterface $itemQueryRepository
     * @param ItemCommandRepositoryInterface $itemCommandRepository
     */
    public function __construct(
        Connection $connection,
        ItemQueryRepositoryInterface $itemQueryRepository,
        ItemCommandRepositoryInterface $itemCommandRepository
    ) {
        $this->doctrineConnection = $connection;
        $this->itemQueryRepository = $itemQueryRepository;
        $this->itemCommandRepository = $itemCommandRepository;
    }

    /**
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     * @Given I'm find Items collection interface which I want to delete
     */
    public function imFindItemsCollectionInterfaceWhichIWantToDelete()
    {
        $this->items =
            $this->itemQueryRepository->findListByParagraphId(new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d'));
    }

    /**
     * @throws FailMakeItemModel
     * @throws InvalidItemIdException
     * @throws InvalidItemTypeIdException
     * @throws InvalidParagraphIdException
     * @throws ConnectionException
     * @When I Call Method Delete
     */
    public function iCallMethodDelete()
    {
        $this->doctrineConnection->beginTransaction();

        $this->itemCommandRepository->deleteList($this->items);
        $this->result =
            $this->itemQueryRepository->findListByParagraphId(new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d'));
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should not get this Items
     */
    public function iShouldNotGetThisItems()
    {
        Assert::assertEquals($this->result->count() === 0, true);
    }
}
