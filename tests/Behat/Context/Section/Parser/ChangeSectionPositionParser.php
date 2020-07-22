<?php

namespace App\Tests\Behat\Context\Section\Parser;

use App\App\Command\Section\ChangeSectionPositionCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Infrastructure\Exception\Section\FailChangeSectionPositionAction;
use App\Infrastructure\Parser\Section\ChangeSectionPositionParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class ChangeSectionPositionParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var ChangeSectionPositionParserInterface */
    private $changeSectionPositionParser;
    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var ChangeSectionPositionCommandInterface */
    private $parsingResult;

    /**
     * ChangeSectionPositionParser constructor.
     * @param MockRequestInterface $mockRequest
     * @param ChangeSectionPositionParserInterface $changeSectionPositionParser
     */
    public function __construct(
        MockRequestInterface $mockRequest,
        ChangeSectionPositionParserInterface $changeSectionPositionParser
    ) {
        $this->mockRequest = $mockRequest;
        $this->changeSectionPositionParser = $changeSectionPositionParser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['changeSectionPositionRequest'] = [
            'id' => "0f016e65-748f-4d23-9a85-af7d163576b9",
            'newPosition' => "2"
        ];
    }

    /**
     * @When I call ChangeSectionPositionParser
     */
    public function iCallChangesectionpositionparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->changeSectionPositionParser->parse($mockRequest);
        } catch (InvalidArgumentException | FailChangeSectionPositionAction |
            InvalidSectionIdException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get ChangeSectionPositionCommandInterface command
     * @throws Exception
     */
    public function iShouldGetChangesectionpositioncommandinterfaceCommand()
    {
        if (!$this->parsingResult instanceof ChangeSectionPositionCommandInterface) {
            throw new \Exception(
                "Parsing Result is not ChangeSectionPositionCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }

        if (!$this->parsingResult->getModifiedBy()) {
            throw new \Exception(
                "ChangeSectionPositionCommand object does not have User."
                ."\nError: {$this->exception->getMessage()}"
            );
        }
    }

    /**
     * @param $paramName
     * @Given param :paramName is empty
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData['changeSectionPositionRequest'][$paramName]);
    }

    /**
     * @param $exceptionMessage
     * @throws Exception
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
        $this->requestData['changeSectionPositionRequest'][$paramName] = $paramValue;
    }
}
