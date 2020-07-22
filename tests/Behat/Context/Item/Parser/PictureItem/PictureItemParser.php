<?php


namespace App\Tests\Behat\Context\Item\Parser\PictureItem;

use Behat\Behat\Tester\Exception\PendingException;
use App\App\Command\Item\PictureItem\PictureItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;
use App\Infrastructure\Parser\Item\PictureItem\CreatePictureItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class PictureItemParser implements Context
{
    /** @var array */
    private $requestData;
    /** @var CreatePictureItemParserInterface */
    private $parser;
    private $parsingResult;
    private $exception;
    /**
     * InputItemParser constructor.
     * @param CreatePictureItemParserInterface $parser
     */
    public function __construct(CreatePictureItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
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
     * @When I call Create Picture Item
     */
    public function iCallCreatePictureItem()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($mockRequest);
        } catch (FailCreatePictureItem $exception)
        {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get Create Picture Item Command Interface command
     */
    public function iShouldGetCreatePictureItemCommandInterfaceCommand()
    {
        Assert::assertInstanceOf(PictureItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :arg1 is empty
     */
    public function paramIsEmpty($arg1)
    {
        unset($this->requestData['createPictureItem'][$arg1]);
    }

    /**
     * @Then I should get Exception :exceptionMessage
     *
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
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->requestData['createPictureItem'][$paramName] = $paramValue;
    }
}
