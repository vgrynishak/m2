<?php

namespace App\Tests\Behat\Context\Item\Mapper\ItemType;

use App\App\Doctrine\Entity\Item\ItemType as ItemTypeEntity;
use App\App\Doctrine\Repository\Item\ItemTypeRepository;
use App\App\Mapper\Item\ItemType\ItemTypeEntityMapperInterface;
use App\Core\Model\Item\ItemType\ItemTypeInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ItemTypeEntityMapper implements Context
{
    /** @var ItemTypeRepository */
    private $itemTypeRepository;
    /** @var ItemTypeEntityMapperInterface */
    private $mapper;
    /** @var ItemTypeEntity */
    private $itemTypeEntity;
    /** @var ItemTypeInterface */
    private $itemType;

    public function __construct(
        ItemTypeRepository $itemTypeRepository,
        ItemTypeEntityMapperInterface $mapper
    ) {
        $this->itemTypeRepository = $itemTypeRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Given I'm Set exists ItemType entity
     */
    public function imSetExistsItemtypeEntity()
    {
        $this->itemTypeEntity = $this->itemTypeRepository->find('short_text_input');
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->itemType = $this->mapper->map($this->itemTypeEntity);
    }

    /**
     * @Then I should get same ItemTypeModel
     */
    public function iShouldGetSameItemtypemodel()
    {
        Assert::assertInstanceOf(ItemTypeInterface::class, $this->itemType);
    }
}