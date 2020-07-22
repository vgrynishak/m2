<?php

namespace App\Tests\Behat\Context\ReportTemplate\Parser;

use App\App\Command\ReportTemplate\PublishReportTemplateCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Infrastructure\Exception\ReportTemplate\FailPublishReportTemplateAction;
use App\Infrastructure\ParamConverter\ReportTemplate\ReportTemplateIdConverterInterface;
use App\Infrastructure\Parser\ReportTemplate\PublishReportTemplateParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class PublishReportTemplateParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var ReportTemplateIdConverterInterface */
    private $reportTemplateIdConverter;
    /** @var PublishReportTemplateParserInterface */
    private $publishReportTemplateParser;
    /** @var PublishReportTemplateCommandInterface */
    private $parsingResult;

    /**
     * PublishReportTemplateParser constructor.
     * @param PublishReportTemplateParserInterface $publishReportTemplateParser
     * @param ReportTemplateIdConverterInterface $converter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        PublishReportTemplateParserInterface $publishReportTemplateParser,
        ReportTemplateIdConverterInterface $converter,
        MockRequestInterface $mockRequest
    ) {
        $this->publishReportTemplateParser = $publishReportTemplateParser;
        $this->reportTemplateIdConverter = $converter;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['reportTemplateId'] = "6647e03a-4f98-4a25-acc7-0ebad8fba230";
    }

    /**
     * @When I call PublishReportTemplateParser
     */
    public function iCallPublishreporttemplateparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], [], $this->requestData);
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

            $this->parsingResult = $this->publishReportTemplateParser->parse($mockRequest);
        } catch (InvalidReportTemplateIdException |
                FailPublishReportTemplateAction |
                InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get PublishReportTemplateCommandInterface
     */
    public function iShouldGetPublishreporttemplatecommandinterface()
    {
        if (!$this->parsingResult instanceof PublishReportTemplateCommandInterface) {
            throw new Exception(
                "Parsing Result is not PublishReportTemplateCommand object."
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
        unset($this->requestData[$paramName]);
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
        $this->requestData[$paramName] = $paramValue;
    }
}
