<?php

namespace App\Tests\Behat\Context\ReportTemplate\Parser;

use App\App\Command\ReportTemplate\EditReportTemplateCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Infrastructure\Exception\ReportTemplate\FailEditReportTemplateAction;
use App\Infrastructure\ParamConverter\ReportTemplate\ReportTemplateIdConverterInterface;
use App\Infrastructure\Parser\ReportTemplate\EditReportTemplateParserInterface;
use Behat\Behat\Context\Context;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class EditReportTemplateParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var ReportTemplateIdConverterInterface */
    private $reportTemplateIdConverter;
    /** @var Exception */
    private $exception;
    /** @var EditReportTemplateParserInterface */
    private $editReportTemplateParser;
    /** @var EditReportTemplateCommandInterface */
    private $parsingResult;
    /** @var MockRequestInterface */
    private $mockRequest;

    /**
     * EditReportTemplateParser constructor.
     * @param EditReportTemplateParserInterface $editReportTemplateParser
     * @param ReportTemplateIdConverterInterface $converter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        EditReportTemplateParserInterface $editReportTemplateParser,
        ReportTemplateIdConverterInterface $converter,
        MockRequestInterface $mockRequest
    ) {
        $this->editReportTemplateParser = $editReportTemplateParser;
        $this->reportTemplateIdConverter = $converter;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['editReportTemplateRequest'] = [
            'name' => "change_me"
        ];
        $this->requestData['reportTemplateId'] = "6647e03a-4f98-4a25-acc7-0ebad8fba230";
    }

    /**
     * @When I call EditReportTemplateParser
     */
    public function iCallEditreporttemplateparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->requestData, $this->requestData);
            /** @var array $paramConverterData */
            $paramConverterData = [
                'name' => 'reportTemplateId',
                'class' => 'App\Core\Model\ReportTemplate\ReportTemplateId',
                'isOptional' => false,
                'converter' => 'report_template_id.param_converter'
            ];
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->reportTemplateIdConverter->apply($mockRequest, $paramConverter);

            $this->parsingResult = $this->editReportTemplateParser->parse($mockRequest);
        } catch (InvalidReportTemplateIdException |
            FailEditReportTemplateAction |
            InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get EditReportTemplateCommand command
     */
    public function iShouldGetEditreporttemplatecommandCommand()
    {
        if (!$this->parsingResult instanceof EditReportTemplateCommandInterface) {
            throw new Exception(
                "Parsing Result is not EditReportTemplateCommand object."
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
        if ($paramName == 'reportTemplateId') {
            unset($this->requestData[$paramName]);
        } else {
            unset($this->requestData['editReportTemplateRequest'][$paramName]);
        }
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
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->requestData['incorrectParentKey'] = [
            'reportTemplateId' => "6647e03a-4f98-4a25-acc7-0ebad8fba230",
            'name' => "change_me"
        ];
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @Given I'm set param :paramName with next value :paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        if ($paramName == 'reportTemplateId') {
            $this->requestData[$paramName] = $paramValue;
        } else {
            $this->requestData['editReportTemplateRequest'][$paramName] = $paramValue;
        }
    }
}
