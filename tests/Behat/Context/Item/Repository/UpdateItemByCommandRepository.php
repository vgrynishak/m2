<?php

namespace App\Tests\Behat\Context\Item\Repository;

use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;
use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\Core\Model\Item\InputItem\InputItemInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Parser\Item\InputItem\UpdateInputItemParserInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class UpdateItemByCommandRepository implements Context
{
    /** @var UpdateInputItemParserInterface */
    private $parser;
    /** @var ItemCommandRepositoryInterface */
    private $commandRepository;
    /** @var array */
    private $requestData;
    /** @var InputItemInterface */
    private $item;
    /** @var ItemMapperByCommandInterface */
    private $mapper;
    /** @var ItemRepository */
    private $itemRepository;
    /** @var Connection */
    private $doctrineConnection;
    private $result;

    public function __construct(
        ItemCommandRepositoryInterface $commandRepository,
        UpdateInputItemParserInterface $parser,
        ItemMapperByCommandInterface $mapper,
        ItemRepository $itemRepository,
        Connection $connection
    ) {
        $this->commandRepository = $commandRepository;
        $this->parser = $parser;
        $this->mapper = $mapper;
        $this->itemRepository = $itemRepository;
        $this->doctrineConnection= $connection;
    }

    private function prepareData()
    {
        $this->requestData['updateInputItem'] = [
            'id' => '63bea125-46f1-4d59-b6ec-65000d13ac1a',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'label' => 'updated',
            'printable' => false,
            'itemTypeId' => 'short_text_input',
            'placeholder' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
        ];
    }

    /**
     * @Given I'm Set correct Item model
     */
    public function imSetCorrectItemModel()
    {
        $this->prepareData();
        $request = new Request([], $this->requestData);
        $command = $this->parser->parse($request);
        $this->item = $this->mapper->map($command);
        $this->item->setPosition(1);
    }

    /**
     * @When I Call Method update
     */
    public function iCallMethodUpdate()
    {
        $this->doctrineConnection->beginTransaction();
        $this->commandRepository->update($this->item);
        $this->result = $this->itemRepository->find($this->item->getId()->getValue());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get updated data item
     */
    public function iShouldGetUpdatedDataItem()
    {
        Assert::assertInstanceOf(Item::class, $this->result);
    }
}
