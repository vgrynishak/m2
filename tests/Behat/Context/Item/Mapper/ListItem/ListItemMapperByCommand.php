<?php

namespace App\Tests\Behat\Context\Item\Mapper\ListItem;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;
use App\Core\Model\Item\ListItem\QuickSelectItem;
use App\Core\Model\Item\ListItem\SingleSelectListItem;
use App\Infrastructure\Parser\Item\ListItem\CreateListItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ListItemMapperByCommand implements Context
{
    /** @var CreateListItemParserInterface */
    private $parser;
    /** @var ItemMapperByCommandInterface */
    private $mapper;
    /** @var array */
    private $requestData;
    private $result;
    /** @var CreateListItemCommandInterface */
    private $command;

    public function __construct(CreateListItemParserInterface $parser, ItemMapperByCommandInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->parser = $parser;
    }

    private function prepareData(): void
    {
        $this->requestData['createListItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'shortTextInput',
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
     * @Given I'm Set ListInputCommand with itemType quick_select
     */
    public function imSetListInputCommandWithItemTypeQuickSelect(): void
    {
        $this->prepareData();
        $this->requestData['createListItem']['itemTypeId'] = 'quick_select';
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap(): void
    {
        $this->result = $this->mapper->map($this->command);
    }

    /**
     * @Then I should get QuickSelectItem
     */
    public function iShouldGetQuickSelectItem(): void
    {
        Assert::assertInstanceOf(QuickSelectItem::class, $this->result);
    }

    /**
     * @Given I'm Set ListInputCommand with itemType single_selection_list
     */
    public function imSetListInputCommandWithItemTypeSingleSelectionList(): void
    {
        $this->prepareData();
        $this->requestData['createListItem']['itemTypeId'] = 'single_selection_list';
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);
    }

    /**
     * @Then I should get SingleSelectListItem
     */
    public function iShouldGetSingleSelectListItem(): void
    {
        Assert::assertInstanceOf(SingleSelectListItem::class, $this->result);
    }
}
