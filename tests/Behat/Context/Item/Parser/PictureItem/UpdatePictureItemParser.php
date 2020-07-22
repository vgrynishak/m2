<?php

namespace App\Tests\Behat\Context\Item\Parser\PictureItem;

use Behat\Behat\Tester\Exception\PendingException;
use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;
use App\Infrastructure\Parser\Item\PictureItem\UpdatePictureItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;

class UpdatePictureItemParser  implements Context
{
    /** @var array */
    private $requestData;
    /** @var UpdatePictureItemParserInterface */
    private $parser;
    private $parsingResult;
    private $exception;

    public function __construct(UpdatePictureItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['updatePictureItem'] = [
            'id' => 'b825dbb7-c20e-44ce-b029-723338c0dbe7',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13004d13ac9f',
            'itemTypeId' => 'photo',
            'label' => 'test update',
            'NFPAref' => '1',
            'required' => true,
            'remembered' => true,
            'printable' => true
        ];
    }

    /**
     * @When I call Update Picture Item
     * @throws FailCreatePictureItem
     */
    public function iCallUpdatePictureItem()
    {
        try {
            /** @var Request $mockRequest */
            $request = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($request);
        } catch (FailUpdatePictureItem $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get Update Picture Item Command Interface command
     */
    public function iShouldGetUpdatePictureItemCommandInterfaceCommand()
    {
        Assert::assertInstanceOf(UpdatePictureItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :paramName is empty
     * @param $paramName
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData['updatePictureItem'][$paramName]);
    }

    /**
     * @Then I should get Exception :exceptionMessage
     * @param $exceptionMessage
     * @throws \Exception
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
        $this->requestData['incorrectKey'] = [
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13004d13ac9f',
            'label' => 'test',
        ];
    }

    /**
     * @Given I'm set param :paramName with next value :paramValue
     * @param $paramName
     * @param $paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->requestData['updatePictureItem'][$paramName] = $paramValue;
    }
}
