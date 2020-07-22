<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\App\Command\Paragraph\ChangeParagraphPositionCommandInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Exception\Paragraph\FailChangeParagraphPositionAction;
use App\Infrastructure\Parser\Paragraph\ChangeParagraphPositionParserInterface;
use Behat\Behat\Context\Context;
use App\App\Component\Mock\Request\MockRequestInterface;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class ChangeParagraphPositionParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var ChangeParagraphPositionParserInterface */
    private $changeParagraphPositionParser;
    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var ChangeParagraphPositionCommandInterface */
    private $parsingResult;

    /**
     * ChangeParagraphPositionParser constructor.
     *
     * @param MockRequestInterface $mockRequest
     * @param ChangeParagraphPositionParserInterface $changeParagraphPositionParser
     */
    public function __construct(
        MockRequestInterface $mockRequest,
        ChangeParagraphPositionParserInterface $changeParagraphPositionParser
    ) {
        $this->mockRequest = $mockRequest;
        $this->changeParagraphPositionParser = $changeParagraphPositionParser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['changeParagraphPositionRequest'] = [
            'id' => "63bea125-46f1-4d59-b6ec-13000d13ac9f",
            'newPosition' => "4"
        ];
    }

    /**
     * @When I call ChangeParagraphPositionParser
     */
    public function iCallChangeparagraphpositionparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->changeParagraphPositionParser->parse($mockRequest);
        } catch (InvalidArgumentException | FailChangeParagraphPositionAction |
        InvalidParagraphIdException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     *
     * @Then I should get ChangeParagraphPositionCommandInterface command
     */
    public function iShouldGetChangeparagraphpositioncommandinterfaceCommand()
    {
        if (!$this->parsingResult instanceof ChangeParagraphPositionCommandInterface) {
            throw new \Exception(
                "Parsing Result is not ChangeParagraphPositionCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }

        if (!$this->parsingResult->getModifiedBy()) {
            throw new \Exception(
                "ChangeParagraphPositionCommand object does not have User."
                ."\nError: {$this->exception->getMessage()}"
            );
        }
    }

    /**
     * @param $paramName
     *
     * @Given param :paramName is empty
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData['changeParagraphPositionRequest'][$paramName]);
    }

    /**
     * @param $exceptionMessage
     * @throws Exception
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
        $this->requestData['changeParagraphPositionRequest'][$paramName] = $paramValue;
    }
}
