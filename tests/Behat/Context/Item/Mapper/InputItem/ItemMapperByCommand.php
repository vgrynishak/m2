<?php

namespace App\Tests\Behat\Context\Item\Mapper\InputItem;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;
use App\Core\Model\Item\InputItem\InputItemInterface;
use App\Infrastructure\Parser\Item\InputItem\CreateInputItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ItemMapperByCommand implements Context
{
    /** @var CreateInputItemParserInterface */
    private $parser;
    /** @var ItemMapperByCommandInterface */
    private $mapper;
    /** @var array */
    private $requestData;
    /** @var InputItemInterface */
    private $result;
    /** @var CreateInputItemCommandInterface */
    private $command;

    public function __construct(CreateInputItemParserInterface $parser, ItemMapperByCommandInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->parser = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createInputItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'label' => 'test',
            'itemTypeId' => 'short_text_input',
            'defaultAnswer' => [
                'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                'position' => 1,
                'value' => 'Some default answer',
                'answerAssessment' => 'none'
            ],
            'placeholder' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
        ];
    }

    /**
     * @Given I'm Set TextInputCommand
     */
    public function imSetTextInputCommand(): void
    {
        $this->prepareData();
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
     * @Then I should get InputItemInterface
     */
    public function iShouldGetInputItemInterface(): void
    {
        Assert::assertInstanceOf(InputItemInterface::class, $this->result);
    }
}
