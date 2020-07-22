<?php

namespace App\Tests\Behat\Context\Item\Repository;

use App\App\Doctrine\Entity\Item\Item;
use App\App\Doctrine\Repository\Item\ItemRepository;
use App\Core\Model\Item\ListItem\ListItemInterface;
use App\Core\Repository\Item\ItemCommandRepositoryInterface;
use App\Infrastructure\Parser\Item\ListItem\CreateListItemParserInterface;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;

class ListItemCommandRepository implements Context
{
    /** @var CreateListItemParserInterface */
    private $parser;
    /** @var ItemCommandRepositoryInterface */
    private $commandRepository;
    /** @var array */
    private $requestData;
    /** @var ListItemInterface */
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
        CreateListItemParserInterface $parser,
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
        $this->requestData['createListItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'quick_select',
            'label' => 'test',
            'answers' => [
                [
                    'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                    'position' => 1,
                    'value' => 'Some default answer'
                ],
                [
                    'answerId' => 'e7c82207-59cf-460f-981c-a8d1a5fdd3fd',
                    'position' => 1,
                    'value' => 'Some answer 1'
                ],
                [
                    'answerId' => '97522594-1483-4fb6-aaa8-f2e452a3902e',
                    'position' => 1,
                    'value' => 'Some answer 2'
                ]
            ],
            'defaultAnswer' => [
                'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            ],
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
     * @When I Call Method Create
     */
    public function iCallMethodCreate()
    {
        $this->doctrineConnection->beginTransaction();
        $this->commandRepository->create($this->item);
        $this->result = $this->itemRepository->find($this->item->getId()->getValue());
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should get created item
     */
    public function iShouldGetCreatedItem()
    {
        Assert::assertInstanceOf(Item::class, $this->result);
    }
}
