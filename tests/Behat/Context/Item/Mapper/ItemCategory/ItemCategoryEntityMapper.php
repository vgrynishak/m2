<?php

namespace App\Tests\Behat\Context\Item\Mapper\ItemCategory;

use App\App\Doctrine\Entity\Item\ItemCategory as ItemCategoryEntity;
use App\App\Doctrine\Repository\Item\ItemCategoryRepository;
use App\App\Mapper\Item\ItemCategory\ItemCategoryEntityMapperInterface;
use App\Core\Model\Item\ItemCategory\ItemCategoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ItemCategoryEntityMapper implements Context
{
    /** @var ItemCategoryRepository */
    private $itemCategoryRepository;
    /** @var ItemCategoryEntityMapperInterface */
    private $mapper;
    /** @var ItemCategoryEntity */
    private $itemCategoryEntity;
    /** @var ItemCategoryInterface */
    private $itemCategory;

    public function __construct(
        ItemCategoryRepository $itemCategoryRepository,
        ItemCategoryEntityMapperInterface $mapper
    )
    {
        $this->itemCategoryRepository = $itemCategoryRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Given I'm Set exists ItemCategory entity
     */
    public function imSetExistsItemcategoryEntity()
    {
        $this->itemCategoryEntity = $this->itemCategoryRepository->find('question');
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->itemCategory = $this->mapper->map($this->itemCategoryEntity);
    }

    /**
     * @Then I should get same ItemCategoryModel
     */
    public function iShouldGetSameItemcategorymodel()
    {
        Assert::assertInstanceOf(ItemCategoryInterface::class, $this->itemCategory);
    }
}