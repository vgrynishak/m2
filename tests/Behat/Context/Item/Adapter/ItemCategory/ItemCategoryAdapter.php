<?php

namespace App\Tests\Behat\Context\Item\Adapter\ItemCategory;

use App\Core\Repository\Item\ItemType\ItemTypeQueryRepositoryInterface;
use App\Infrastructure\Adapter\Item\ItemCategory\Full;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class ItemCategoryAdapter implements Context
{
    /** @var CollectionInterface */
    private $itemCategories;
    /** @var array */
    private $adapterResult;
    /** @var ItemTypeQueryRepositoryInterface */
    private $itemTypeRepository;

    public function __construct(ItemTypeQueryRepositoryInterface $itemTypeRepository)
    {
        $this->itemTypeRepository = $itemTypeRepository;
    }

    /**
     * @Given Item Category Collection with Item Types Collection
     */
    public function itemCategoryCollectionWithItemTypesCollection()
    {
        $this->itemCategories = $this->itemTypeRepository->findAllForParagraphWithoutDevice();
    }

    /**
     * @When I call static method adaptCollection
     */
    public function iCallStaticMethodAdaptcollection()
    {
        $this->adapterResult = Full::adaptCollection($this->itemCategories);
    }

    /**
     * @Then I should have array of Item Category DTO
     */
    public function iShouldHaveArrayOfItemCategoryDto()
    {
        Assert::assertInstanceOf(CollectionInterface::class, $this->itemCategories);
    }
}
