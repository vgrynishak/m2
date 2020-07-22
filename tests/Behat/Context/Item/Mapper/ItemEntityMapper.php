<?php

namespace App\Tests\Behat\Context\Item\Mapper;

use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\App\Mapper\Item\ItemEntityMapperInterface;
use App\Core\Model\Item\ItemInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ItemEntityMapper implements Context
{
    /** @var ItemEntityMapperInterface */
    private $mapper;

    /** @var ItemRepository */
    private $itemRepository;

    /** @var Item */
    private $itemOrm;

    /** @var ItemInterface */
    private $item;

    public function __construct(ItemEntityMapperInterface $mapper, ItemRepository $itemRepository)
    {
        $this->mapper = $mapper;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @Given I'm Set exists Input entity
     */
    public function imSetExistsInputEntity()
    {
        $this->itemOrm = $this->itemRepository->find('63bea125-46f1-4d59-b6ec-65000d13ac1a');
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->item = $this->mapper->map($this->itemOrm);
    }

    /**
     * @Then I should get same InputModel
     */
    public function iShouldGetSameInputmodel()
    {
        Assert::assertInstanceOf(ItemInterface::class, $this->item);
    }
}
