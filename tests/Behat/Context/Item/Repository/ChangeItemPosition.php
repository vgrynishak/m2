<?php

namespace App\Tests\Behat\Context\Item\Repository;

use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Mapper\Item\ItemEntityMapperInterface;
use App\Core\Model\Item\ItemInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;

class ChangeItemPosition implements Context
{
    /** @var Connection */
    private $connection;
    /** @var ItemRepository */
    private $itemRepository;
    /** @var ItemCommandRepositoryInterface */
    private $itemCommandRepository;
    /** @var ItemEntityMapperInterface */
    private $itemEntityMapper;
    /** @var ItemInterface */
    private $item;
    /** @var int */
    private $newPosition;
    /** @var array */
    private $arrayItemsId;

    /**
     * ChangeItemPosition constructor.
     * @param Connection $connection
     * @param ItemRepository $itemRepository
     * @param ItemCommandRepositoryInterface $itemCommandRepository
     * @param ItemEntityMapperInterface $itemEntityMapper
     */
    public function __construct(
        Connection $connection,
        ItemRepository $itemRepository,
        ItemCommandRepositoryInterface $itemCommandRepository,
        ItemEntityMapperInterface $itemEntityMapper
    ) {
        $this->connection = $connection;
        $this->itemRepository = $itemRepository;
        $this->itemCommandRepository = $itemCommandRepository;
        $this->itemEntityMapper = $itemEntityMapper;
    }

    /**
     * @Given param with id :arg1
     */
    public function paramWithId($id)
    {
        $itemEntity = $this->itemRepository->find($id);
        $this->item = $this->itemEntityMapper->map($itemEntity);
    }

    /**
     * @Given param position :arg1 which i want to change
     */
    public function paramPositionWhichIWantToChange($newPosition)
    {
        $this->newPosition = (int)$newPosition;
    }

    /**
     * @When I call changePosition
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function iCallChangeposition()
    {
        $this->connection->beginTransaction();
        $this->itemCommandRepository->changePosition($this->item, $this->newPosition);

        $items = $this->itemRepository->findAll();
        foreach ($items as $item) {
            $this->arrayItemsId[] = $item->getId();
        }
        $this->connection->rollBack();
    }

    /**
     * @Then compare state list paragraph with increased list item
     */
    public function compareStateListParagraphWithIncreasedListItem()
    {
        $rightArray = ['63bea125-46f1-4d59-b6ec-65000d13ac1a', 'b825dbb7-c20e-44ce-b029-723338c0dbe7','b825dbb7-c20e-44ce-b029-723338c0dbe6'];
        $diffArrayCount = count(array_diff($rightArray, $this->arrayItemsId));

        Assert::assertSame($diffArrayCount, 0);
    }

    /**
     * @Then compare state list paragraph with decreased list item
     */
    public function compareStateListParagraphWithDecreasedListItem()
    {
        $rightArray = ['b825dbb7-c20e-44ce-b029-723338c0dbe7','b825dbb7-c20e-44ce-b029-723338c0dbe6','63bea125-46f1-4d59-b6ec-65000d13ac1a'];
        $diffArrayCount = count(array_diff($rightArray, $this->arrayItemsId));

        Assert::assertSame($diffArrayCount, 0);
    }
}
