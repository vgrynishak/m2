<?php

namespace App\Tests\Behat\Context\ReportTemplate\Parser;

use App\App\Command\ReportTemplate\ArchiveReportTemplateCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Infrastructure\Exception\ReportTemplate\FailArchiveReportTemplateAction;
use App\Infrastructure\Exception\ReportTemplate\FailDeleteReportTemplateAction;
use App\Infrastructure\ParamConverter\ReportTemplate\ReportTemplateIdConverterInterface;
use App\Infrastructure\Parser\ReportTemplate\ArchiveReportTemplateParserInterface;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Exception;

class ArchiveReportTemplateParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var ReportTemplateIdConverterInterface */
    private $reportTemplateIdConverter;
    /** @var Exception */
    private $exception;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var ArchiveReportTemplateParserInterface */
    private $archiveReportTemplateParser;
    /** @var ArchiveReportTemplateCommandInterface */
    private $parsingResult;

    /**
     * ArchiveReportTemplateParser constructor.
     * @param ArchiveReportTemplateParserInterface $archiveReportTemplateParser
     * @param ReportTemplateIdConverterInterface $converter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        ArchiveReportTemplateParserInterface $archiveReportTemplateParser,
        ReportTemplateIdConverterInterface $converter,
        MockRequestInterface $mockRequest
    ) {
        $this->archiveReportTemplateParser = $archiveReportTemplateParser;
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
     * @When I call ArchiveReportTemplateParser
     */
    public function iCallArchivereporttemplateparser()
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

            $this->parsingResult = $this->archiveReportTemplateParser->parse($mockRequest);
        } catch (InvalidReportTemplateIdException |
                FailArchiveReportTemplateAction |
                InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get ArchiveReportTemplateCommand command
     */
    public function iShouldGetArchivereporttemplatecommandCommand()
    {
        if (!$this->parsingResult instanceof ArchiveReportTemplateCommandInterface) {
            throw new Exception(
                "Parsing Result is not ArchiveReportTemplateCommand object."
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
