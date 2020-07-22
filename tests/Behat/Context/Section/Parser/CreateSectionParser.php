<?php

namespace App\Tests\Behat\Context\Section\Parser;

use App\App\Command\Section\CreateSectionCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Infrastructure\Exception\Section\FailCreateSectionAction;
use App\Infrastructure\Parser\Section\CreateSectionParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateSectionParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var CreateSectionParserInterface */
    private $createSectionParser;
    /** @var Exception */
    private $exception;
    /** @var CreateSectionCommandInterface */
    private $parsingResult;
    /** @var array */
    private $data;

    /**
     * CreateSectionParser constructor.
     * @param CreateSectionParserInterface $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(CreateSectionParserInterface $parser, MockRequestInterface $mockRequest)
    {
        $this->createSectionParser = $parser;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->data['createSectionRequest'] = [
            "sectionId" => "6647e03a-4f98-4a25-acc7-0ebad8fba330",
            "reportTemplateId" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
            "title" => "new_title"
        ];
    }

    /**
     * @When I call CreateSectionParser
     */
    public function iCallCreatesectionparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->data);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->createSectionParser->parse($mockRequest);
        } catch (InvalidArgumentException |
            FailCreateSectionAction |
            InvalidReportTemplateIdException |
            InvalidServiceIdException
            $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get CreateSectionCommandInterface
     */
    public function iShouldGetCreatesectioncommandinterface()
    {
        if (!$this->parsingResult instanceof CreateSectionCommandInterface) {
            throw new Exception(
                "Parsing Result is not CreateSectionCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }
    }

    /**
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        unset($this->data['createSectionRequest'][$param]);
    }

    /**
     * @param $exceptionMessage
     * @throws Exception
     * @Then I should get Exception :exceptionMessage
     */
    public function iShouldGetException($exceptionMessage)
    {
        if (!$this->exception instanceof Exception) {
            throw new Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @Given I'm set param :paramName with next value :paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->data['createSectionRequest'][$paramName] = $paramValue;
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->data = ['wrongKey' => []];
    }
}
