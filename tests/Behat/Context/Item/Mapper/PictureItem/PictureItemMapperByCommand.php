<?php


namespace App\Tests\Behat\Context\Item\Mapper\PictureItem;

use App\App\Command\Item\Mapper\ItemMapperByCommandInterface;
use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\Core\Model\Item\PictureItem\PictureItemInterface;
use App\Infrastructure\Parser\Item\PictureItem\CreatePictureItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class PictureItemMapperByCommand  implements Context
{
    /** @var CreatePictureItemParserInterface */
    private $parser;
    /** @var ItemMapperByCommandInterface */
    private $mapper;
    /** @var array */
    private $requestData;
    private $result;
    /** @var CreatePictureItemCommandInterface */
    private $command;

    public function __construct(CreatePictureItemParserInterface $parser, ItemMapperByCommandInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->parser = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createPictureItem'] = [
            'id' => 'b825dbb7-c20e-44ce-b029-723338c0dbe7',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13004d13ac9f',
            'itemTypeId' => 'photo',
            'label' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true,
            'printable' => true
        ];
    }

    /**
     * @Given I'm Set Picture Input Command
     */
    public function imSetPictureInputCommand()
    {
        $this->prepareData();
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);
    }

    /**
     * @When I Call Method Map
     */
    public function iCallMethodMap()
    {
        $this->result = $this->mapper->map($this->command);
    }

    /**
     * @Then I should get Input Item Interface
     */
    public function iShouldGetInputItemInterface()
    {
        Assert::assertInstanceOf(PictureItemInterface::class, $this->result);
    }
}
