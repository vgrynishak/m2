<?php

namespace App\Tests\Behat\Context\Item\Repository\ItemCategory;

use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class ItemCategoryQueryRepository implements Context
{
    /** @var ItemTypeQueryRepositoryInterface */
    private $repository;
    /** @var CollectionInterface */
    private $itemCategories;

    public function __construct(
        ItemTypeQueryRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @When I Call Method FindAll
     */
    public function iCallMethodFindAll()
    {
        $this->itemCategories = $this->repository->findAllForParagraphWithoutDevice();
    }

    /**
     * @Then I should get Collection Interface
     */
    public function iShouldGetCollectionInterface()
    {
        Assert::assertInstanceOf(CollectionInterface::class, $this->itemCategories);
    }
}
