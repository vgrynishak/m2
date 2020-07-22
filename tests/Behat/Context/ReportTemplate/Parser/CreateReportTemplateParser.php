<?php

namespace App\Tests\Behat\Context\ReportTemplate\Parser;

use App\App\Command\ReportTemplate\CreateReportTemplateCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Core\Model\Exception\InvalidServiceIdException;
use App\Infrastructure\Exception\ReportTemplate\FailCreateReportTemplateAction;
use App\Infrastructure\Parser\ReportTemplate\CreateReportTemplateParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateReportTemplateParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var CreateReportTemplateParserInterface */
    private $createReportTemplateParser;
    /** @var Exception */
    private $exception;
    /** @var CreateReportTemplateCommandInterface */
    private $parsingResult;
    /** @var array */
    private $data;

    /**
     * CreateReportTemplateParser constructor.
     * @param CreateReportTemplateParserInterface $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(CreateReportTemplateParserInterface $parser, MockRequestInterface $mockRequest)
    {
        $this->createReportTemplateParser = $parser;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->data['createReportTemplateRequest'] = [
            "id" => "6647e03a-4f98-4a25-acc7-0ebad8fba220",
            "deviceId" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
            "serviceId" => "63bea125-46f1-4d59-b6ec-65000d13acc1",
            "name" => "new_rt_name"
        ];
    }

    /**
     * @When I call CreateReportTemplateParser
     */
    public function iCallCreatereporttemplateparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->data);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->createReportTemplateParser->parse($mockRequest);
        } catch (InvalidArgumentException |
            FailCreateReportTemplateAction |
            InvalidReportTemplateIdException |
            InvalidServiceIdException |
            InvalidDeviceIdException
            $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get CreateReportTemplateCommand
     * @throws Exception
     */
    public function iShouldGetCreatereporttemplatecommand()
    {
        if (!$this->parsingResult instanceof CreateReportTemplateCommandInterface) {
            throw new Exception(
                "Parsing Result is not EditReportTemplateCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }
    }

    /**
     * @param $param
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        unset($this->data['createReportTemplateRequest'][$param]);
    }

    /**
     * @param $exceptionMessage
     * @throws Exception
     *
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
        $this->data['createReportTemplateRequest'][$paramName] = $paramValue;
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->data = ['wrongKey' => []];
    }
}
