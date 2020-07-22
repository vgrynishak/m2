<?php

namespace App\Tests\Behat\Context\Item\Parser\ListItem;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateListItem;
use App\Infrastructure\Parser\Item\ListItem\CreateListItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ListItemParser implements Context
{
    /** @var array */
    private $requestData;
    /** @var CreateListItemParserInterface */
    private $parser;
    private $parsingResult;
    private $exception;

    /**
     * InputItemParser constructor.
     * @param CreateListItemParserInterface $parser
     */
    public function __construct(CreateListItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['createListItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'shortTextInput',
            'label' => 'test',
            'answers' => [
                [
                    'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                    'value' => 'Some default answer'
                ],
                [
                    'answerId' => 'e7c82207-59cf-460f-981c-a8d1a5fdd3fd',
                    'value' => 'Some answer 1'
                ],
                [
                    'answerId' => '97522594-1483-4fb6-aaa8-f2e452a3902e',
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
     * @When I call CreateListItemParser
     */
    public function iCallCreateListItemParser(): void
    {
        try {
            /** @var Request $mockRequest */
            $request = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($request);
        } catch (FailCreateListItem $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get CreateListItemCommandInterface command
     */
    public function IShouldGetCreateListItemCommandInterfaceCommand(): void
    {
        Assert::assertInstanceOf(CreateListItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :arg1 is empty
     */
    public function paramIsEmpty($paramName): void
    {
        unset($this->requestData['createListItem'][$paramName]);
    }

    /**
     * @Then I should get Exception :arg1
     * @param $exceptionMessage
     * @throws \Exception
     */
    public function iShouldGetException($exceptionMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception('There is no Exception');
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
        $this->requestData['createListItem'][$paramName] = $paramValue;
    }

    /**
     * @Given param :arg1 :arg2 is empty
     * @param $paramObject
     * @param $paramValue
     */
    public function paramIsEmpty2($paramObject, $paramValue): void
    {
        unset($this->requestData['createListItem'][$paramObject][0][$paramValue]);
    }

    /**
     * @Given param answerId in default Answer is empty
     */
    public function paramAnsweridInDefaultAnswerIsEmpty()
    {
        unset($this->requestData['createListItem']['defaultAnswer']['answerId']);
    }
}
