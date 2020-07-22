<?php

namespace App\Tests\Behat\Context\Item\Parser\InputItem;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateInputItem;
use App\Infrastructure\Parser\Item\InputItem\CreateInputItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class InputItemParser implements Context
{
    /** @var array */
    private $requestData;
    /** @var CreateInputItemParserInterface */
    private $parser;
    private $parsingResult;
    private $exception;

    /**
     * InputItemParser constructor.
     * @param CreateInputItemParserInterface $parser
     */
    public function __construct(CreateInputItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams(): void
    {
        $this->requestData['createInputItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'short_text_input',
            'label' => 'test',
            'defaultAnswer' => [
                'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                'value' => 'Some default answer'
            ],
            'placeholder' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
        ];
    }

    /**
     * @When I call CreateInputItemParser
     */
    public function iCallCreateTextInputParser(): void
    {
        try {
            /** @var Request $mockRequest */
            $request = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($request);
        } catch (FailCreateInputItem $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get CreateInputItemCommandInterface command
     */
    public function iShouldGetCreateTextInputCommandInterfaceCommand(): void
    {
        Assert::assertInstanceOf(CreateInputItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :arg1 is empty
     */
    public function paramIsEmpty($paramName): void
    {
        unset($this->requestData['createInputItem'][$paramName]);
    }

    /**
     * @Then I should get Exception :arg1
     * @param $exceptionMessage
     * @throws \Exception
     */
    public function iShouldGetException($exceptionMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey(): void
    {
        $this->requestData['incorrectKey'] = [
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'label' => 'test',
        ];
    }

    /**
     * @Given I'm set param :arg1 with next value :arg2
     * @param $paramName
     * @param $paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue): void
    {
        $this->requestData['createInputItem'][$paramName] = $paramValue;
    }

    /**
     * @Given param :arg1 :arg2 is empty
     * @param $paramObject
     * @param $paramValue
     */
    public function paramIsEmpty2($paramObject, $paramValue): void
    {
        unset($this->requestData['createInputItem'][$paramObject][$paramValue]);
    }
}
