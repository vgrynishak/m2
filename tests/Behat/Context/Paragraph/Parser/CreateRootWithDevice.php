<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\App\Command\Paragraph\CreateRootWithDeviceCommandInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\User\UserInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use App\Infrastructure\Parser\Paragraph\CreateRootWithDeviceParserInterface;
use Behat\Behat\Context\Context;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Model\Paragraph\ParagraphFilter;

class CreateRootWithDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $data;

    /** @var RootParagraphWithDeviceInterface */
    private $parsingResult;

    /** @var \Exception */
    private $exception;

    /** @var CreateRootWithDeviceParserInterface */
    private $createRootWithDeviceParser;

    /** @var MockRequestInterface */
    private $mockRequest;

    /**
     * CreateChildWithDevice constructor.
     * @param CreateRootWithDeviceParserInterface $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        CreateRootWithDeviceParserInterface $parser,
        MockRequestInterface $mockRequest
    ) {
        $this->createRootWithDeviceParser = $parser;
        $this->mockRequest = $mockRequest;
    }

    private function childWithDeviceDataProvider()
    {
        return [
            "createParagraphRequest" => [
                "id" => "4e8c2b7c-9ab1-4121-94e1-ab075d2acf31",
                "title" => "Root paragraph with device",
                "sectionId" => "6647e03a-4f98-4a25-acc7-0ebad8fba229",
                "deviceId" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
                "filterId" => ParagraphFilter::FILTER_ON_SITE,
                "styleTemplateId" => "3a45f743-424c-4839-a395-ead0cd2e70c3"
            ]
        ];
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->data = $this->childWithDeviceDataProvider();
    }

    /**
     * @param $param
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        $this->data['createParagraphRequest'][$param] = '';
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->data=['wrongKey' => []];
    }

    /**
     * @Then I should get Exception :arg1
     * @param $exceptionMessage
     * @throws \Exception
     */
    public function iShouldGetException($exceptionMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I'm set param :param with incorrect value
     * @param $param
     */
    public function imSetParamWithIncorrectValue($param)
    {
        $strLongerThan100Characters = 'Wrooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
        oooooooooooooooooooooooooooooooooooooooooooooongParam';
        $this->data['createParagraphRequest'][$param] = $strLongerThan100Characters;
    }

    /**
     * @When I call Method Parse
     */
    public function iCallMethodParse()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->data);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->createRootWithDeviceParser->parse($mockRequest);
        } catch (InvalidArgumentException |
            FailCreateAction |
            InvalidParagraphIdException |
            InvalidDeviceIdException |
            InvalidStyleTemplateIdException
            $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get Command implements CreateRootWithDeviceInterface
     */
    public function iShouldGetCommandImplementsCreaterootwithdeviceinterface()
    {
        Assert::assertTrue($this->parsingResult instanceof CreateRootWithDeviceCommandInterface);
    }

    /**
     * @Then I should get FailCreateAction Exception
     */
    public function iShouldGetFailcreateactionException()
    {
        Assert::assertTrue($this->exception instanceof FailCreateAction);
    }

    /**
     * @Then error message should be :message
     * @param $message
     */
    public function errorMessageShouldBe($message)
    {
        Assert::assertEquals($this->exception->getMessage(), $message);
    }

    /**
     * @Then property isPrintable should be true
     */
    public function propertyIsprintableShouldBeTrue()
    {
        Assert::assertEquals($this->parsingResult->isPrintable(), true);
    }

    /**
     * @Then property createdBy should be instance of UserInterface
     */
    public function propertyCreatedbyShouldBeInstanceOfUserinterface()
    {
        Assert::assertTrue($this->parsingResult->getCreatedBy() instanceof UserInterface);
    }

    /**
     * @Then Style Template Id should be default
     */
    public function styleTemplateIdShouldBeDefault()
    {
        /** @var StyleTemplateId $resultStyleTemplateId */
        $resultStyleTemplateId = $this->parsingResult->getStyleTemplateId();

        Assert::assertEquals($resultStyleTemplateId->getValue(), '3a45f743-424c-4839-a395-ead0cd2e70c3');
    }

    /**
     * @Then property header should be instance of CustomHeaderInterface
     */
    public function propertyHeaderShouldBeInstanceOfCustomheaderinterface()
    {
        Assert::assertTrue($this->parsingResult->getHeader() instanceof CustomHeaderInterface);
    }

    /**
     * @param $param
     * @Given param :param is absent
     */
    public function paramIsAbsent($param)
    {
        unset($this->data['createParagraphRequest'][$param]);
    }

    /**
     * @Then Style HeaderType should be instance of DeviceCardInterface
     */
    public function styleHeadertypeShouldBeInstanceOfDevicecardinterface()
    {
        Assert::assertTrue($this->parsingResult->getHeader() instanceof DeviceCardHeaderInterface);
    }
}
