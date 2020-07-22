<?php

namespace App\Tests\Behat\Context\Section\Parser;

use App\App\Command\Section\EditSectionCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Infrastructure\Exception\Section\FailEditSectionAction;
use App\Infrastructure\Parser\Section\EditSectionParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Model\Exception\InvalidSectionIdException;
use InvalidArgumentException;

class EditSectionParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var EditSectionParserInterface */
    private $editSectionParser;
    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var EditSectionCommandInterface */
    private $parsingResult;

    /**
     * EditSectionParser constructor.
     * @param MockRequestInterface $mockRequest
     * @param EditSectionParserInterface $editSectionParser
     */
    public function __construct(
        MockRequestInterface $mockRequest,
        EditSectionParserInterface $editSectionParser
    ) {
        $this->mockRequest = $mockRequest;
        $this->editSectionParser = $editSectionParser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['editSectionRequest'] = [
            'id' => "6647e03a-4f98-4a25-acc7-0ebad8fba229",
            'title' => "change_me"
        ];
    }

    /**
     * @When I call EditSectionParser
     */
    public function iCallEditsectionparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->editSectionParser->parse($mockRequest);
        } catch (InvalidArgumentException | FailEditSectionAction |
            InvalidSectionIdException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get EditSectionCommandInterface command
     */
    public function iShouldGetEditsectioncommandinterfaceCommand()
    {
        if (!$this->parsingResult instanceof EditSectionCommandInterface) {
            throw new Exception(
                "Parsing Result is not EditSectionCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }

        if (!$this->parsingResult->getModifiedBy()) {
            throw new Exception(
                "EditSectionCommand object does not have User."
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
        unset($this->requestData['editSectionRequest'][$paramName]);
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
        $this->requestData['editSectionRequest'][$paramName] = $paramValue;
    }
}
