<?php

namespace App\Tests\Behat\Context\ReportTemplate\Parser;

use App\App\Command\ReportTemplate\GetByIdCommandInterface;
use App\App\Command\ReportTemplate\GetByIdCommand;
use App\Core\Model\Exception\InvalidReportTemplateIdException;
use App\Infrastructure\Exception\ReportTemplate\FailGetByIdAction;
use App\Infrastructure\ParamConverter\ReportTemplate\ReportTemplateIdConverterInterface;
use App\Infrastructure\Parser\ReportTemplate\GetByIdParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class GetById implements Context
{
    /** @var array  */
    private $requestData = [];
    /** @var ReportTemplateIdConverterInterface */
    private $reportTemplateIdConverter;
    /** @var Exception */
    private $exception;
    /** @var GetByIdParserInterface */
    private $getByIdParser;
    /** @var GetByIdCommandInterface */
    private $parsingResult;

    /**
     * GetById constructor.
     * @param ReportTemplateIdConverterInterface $converter
     * @param GetByIdParserInterface $parser
     */
    public function __construct(ReportTemplateIdConverterInterface $converter, GetByIdParserInterface $parser)
    {
        $this->reportTemplateIdConverter = $converter;
        $this->getByIdParser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData = [
            'reportTemplateId' => "63bea125-46f1-4d59-b6ec-65000d13ac34"
        ];
    }

    /**
     * @When I call GetById Parser
     */
    public function iCallGetbyidParser()
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
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->reportTemplateIdConverter->apply($mockRequest, $paramConverter);
            $this->parsingResult = $this->getByIdParser->parse($mockRequest);
        } catch (InvalidReportTemplateIdException | FailGetByIdAction | InvalidArgumentException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     *
     * @Then I should get GetByIdCommandInterface
     */
    public function iShouldGetGetbyidcommandinterface()
    {
        if (!$this->parsingResult instanceof GetByIdCommand) {
            throw new Exception(
                "Parsing Result is not GetByIdCommand object."
                ."\nError: {$this->exception->getMessage()}"
            );
        }
    }

    /**
     * @param $paramName
     *
     * @Given param :arg1 is empty
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData[$paramName]);
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
     * @param $paramName
     * @param $paramValue
     *
     * @Given I'm set param :arg1 with next value :arg2
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->requestData[$paramName] = $paramValue;
    }
}
