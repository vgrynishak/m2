<?php

namespace App\Tests\Behat\Context\Item\Parser\ChangeItemPosition;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Exception\Item\FailChangeItemPosition;
use App\Infrastructure\Exception\Item\FailChangePositionItem;
use App\Infrastructure\Exception\Paragraph\FailChangeParagraphPositionAction;
use App\Infrastructure\Parser\Item\ChangeItemPosition\ChangeItemPositionParserInterface;
use App\Infrastructure\Parser\Paragraph\ChangeParagraphPositionParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ChangeItemPositionParser implements Context
{
    /** @var ChangeItemPositionParserInterface */
    private $changeItemPositionParser;
    /** @var array  */
    private $requestData = [];
    /** @var \Exception */
    private $exception;
    /** @var ChangeItemPositionCommandInterface */
    private $parsingResult;

    /**
     * ChangeItemPosition constructor.
     * @param ChangeItemPositionParserInterface $changeItemPositionParser
     */
    public function __construct(ChangeItemPositionParserInterface $changeItemPositionParser)
    {
        $this->changeItemPositionParser = $changeItemPositionParser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['changeItemPositionRequest'] = [
            'id' => "63bea125-46f1-4d59-b6ec-13000d13ac9f",
            'newPosition' => "4"
        ];
    }

    /**
     * @When I call ChangeItemPositionParser
     */
    public function iCallChangeItemPositionParser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);

            $this->parsingResult = $this->changeItemPositionParser->parse($mockRequest);
        } catch (FailChangeItemPosition $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     *
     * @Then I should get ChangeItemPositionCommandInterface command
     */
    public function iShouldGetChangeItemPositionCommandInterfaceCommand(): void
    {
        Assert::assertInstanceOf(ChangeItemPositionCommandInterface::class, $this->parsingResult);
    }

    /**
     * @param $paramName
     *
     * @Given param :paramName is empty
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData['changeItemPositionRequest'][$paramName]);
    }

    /**
     * @param $exceptionMessage
     * @throws \Exception
     *
     * @Then I should get Exception :exceptionMessage
     */
    public function iShouldGetException($exceptionMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->requestData['incorrectParentKey'] = [
            'id' => "0f016e65-748f-4d23-9a85-af7d163576b9",
            'newPosition' => "2"
        ];
    }

    /**
     * @param $paramName
     * @param $paramValue
     *
     * @Given I'm set param :paramName with next value :paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->requestData['changeItemPositionRequest'][$paramName] = $paramValue;
    }
}
