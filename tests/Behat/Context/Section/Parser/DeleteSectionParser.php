<?php

namespace App\Tests\Behat\Context\Section\Parser;

use App\App\Command\Section\DeleteSectionCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Infrastructure\Exception\Section\FailDeleteSectionAction;
use App\Infrastructure\ParamConverter\Section\SectionIdConverterInterface;
use App\Infrastructure\Parser\Section\DeleteSectionParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DeleteSectionParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var SectionIdConverterInterface */
    private $sectionIdConverter;
    /** @var DeleteSectionParserInterface */
    private $deleteSectionParser;
    /** @var DeleteSectionCommandInterface */
    private $parsingResult;

    /**
     * DeleteSectionParser constructor.
     * @param DeleteSectionParserInterface $deleteSectionParser
     * @param SectionIdConverterInterface $converter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        DeleteSectionParserInterface $deleteSectionParser,
        SectionIdConverterInterface $converter,
        MockRequestInterface $mockRequest
    ) {
        $this->deleteSectionParser = $deleteSectionParser;
        $this->sectionIdConverter = $converter;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['sectionId'] = "6647e03a-4f98-4a25-acc7-0ebad8fba222";
    }

    /**
     * @When I call DeleteSectionParser
     */
    public function iCallDeletesectionparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], [], $this->requestData);
            /** @var array $paramConverterData */
            $paramConverterData = [
                'name' => 'sectionId',
                'class' => 'App\Core\Model\Section\SectionId',
                'isOptional' => false,
                'converter' => 'section_id.param_converter'
            ];
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->sectionIdConverter->apply($mockRequest, $paramConverter);

            $this->parsingResult = $this->deleteSectionParser->parse($mockRequest);
        } catch (InvalidSectionIdException |
                FailDeleteSectionAction |
                InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     *
     * @Then I should get DeleteSectionCommandInterface
     */
    public function iShouldGetDeletesectioncommandinterface()
    {
        if (!$this->parsingResult instanceof DeleteSectionCommandInterface) {
            throw new Exception(
                "Parsing Result is not DeleteSectionCommand object."
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
