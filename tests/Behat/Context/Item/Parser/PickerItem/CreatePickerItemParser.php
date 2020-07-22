<?php

namespace App\Tests\Behat\Context\Item\Parser\PickerItem;

use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Exception\Item\FailCreatePickerItem;
use App\Infrastructure\Parser\Item\PickerItem\CreatePickerItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class CreatePickerItemParser implements Context
{
    /** @var array */
    private $requestData;

    /** @var CreatePickerItemParserInterface */
    private $parser;

    private $parsingResult;

    private $exception;

    /**
     * CreatePickerItemParser constructor.
     * @param CreatePickerItemParserInterface $parser
     */
    public function __construct(CreatePickerItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams(): void
    {
        $this->requestData['createPickerItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13004d13ac9f',
            'itemTypeId' => ItemType::TIME_INTERVAL,
            'label' => 'test',
            'placeholder' => 'placeholder test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true,
            'printable' => true
        ];
    }

    /**
     * @When I call Create Picker Item
     */
    public function iCallCreatePickerItem(): void
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($mockRequest);
        } catch (FailCreatePickerItem $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get CreatePickerItemCommand Interface
     */
    public function iShouldGetCreatePictureItemCommandInterfaceCommand(): void
    {
        Assert::assertInstanceOf(CreatePickerItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :arg1 is empty
     * @param $arg1
     */
    public function paramIsEmpty($arg1): void
    {
        unset($this->requestData['createPickerItem'][$arg1]);
    }

    /**
     * @Then I should get Exception :exceptionMessage
     *
     * @param $exceptionMessage
     * @throws \Exception
     */
    public function iShouldGetException($exceptionMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \RuntimeException('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey(): void
    {
        $this->requestData['incorrectRootKey'] = [
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13004d13ac9f',
            'label' => 'test',
        ];
    }

    /**
     * @Given I'm set param :paramName with next value :paramValue
     * @param $paramName
     * @param $paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue): void
    {
        $this->requestData['createPickerItem'][$paramName] = $paramValue;
    }
}
