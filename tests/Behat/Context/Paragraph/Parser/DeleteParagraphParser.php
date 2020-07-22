<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\App\Command\Paragraph\DeleteParagraphCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Infrastructure\Exception\Paragraph\FailDeleteParagraphAction;
use App\Infrastructure\ParamConverter\Paragraph\ParagraphIdConverterInterface;
use App\Infrastructure\Parser\Paragraph\DeleteParagraphParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DeleteParagraphParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var ParagraphIdConverterInterface */
    private $paragraphIdConverter;
    /** @var DeleteParagraphParserInterface */
    private $deleteParagraphParser;
    /** @var DeleteParagraphCommandInterface */
    private $parsingResult;

    /**
     * DeleteParagraphParser constructor.
     * @param DeleteParagraphParserInterface $deleteParagraphParser
     * @param ParagraphIdConverterInterface $paragraphIdConverter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        DeleteParagraphParserInterface $deleteParagraphParser,
        ParagraphIdConverterInterface $paragraphIdConverter,
        MockRequestInterface $mockRequest
    ) {
        $this->deleteParagraphParser = $deleteParagraphParser;
        $this->paragraphIdConverter = $paragraphIdConverter;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['paragraphId'] = "d1a01008-d6e0-4b6f-9d40-f68f91a34b65";
    }

    /**
     * @When I call DeleteParagraphParser
     */
    public function iCallDeleteparagraphparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], [], $this->requestData);
            /** @var array $paramConverterData */
            $paramConverterData = [
                'name' => 'paragraphId',
                'class' => 'App\Core\Model\Paragraph\ParagraphId',
                'isOptional' => false,
                'converter' => 'paragraph_id.param_converter'
            ];
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->paragraphIdConverter->apply($mockRequest, $paramConverter);

            $this->parsingResult = $this->deleteParagraphParser->parse($mockRequest);
        } catch (InvalidParagraphIdException |
            FailDeleteParagraphAction |
            InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get DeleteParagraphCommandInterface
     */
    public function iShouldGetDeleteparagraphcommandinterface()
    {
        if (!$this->parsingResult instanceof DeleteParagraphCommandInterface) {
            throw new Exception(
                "Parsing Result is not DeleteParagraphCommand object."
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
