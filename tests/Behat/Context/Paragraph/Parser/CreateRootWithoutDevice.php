<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\NoHeaderInterface;
use App\App\Command\Paragraph\CreateRootWithoutDeviceCommandInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\User\UserInterface;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use App\Infrastructure\Parser\Paragraph\CreateRootWithoutDeviceParserInterface;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Infrastructure\Exception\Paragraph\FailCreateRootWithoutDevice;
use App\Infrastructure\Parser\Paragraph\CreateRootWithoutDeviceParser;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\App\Component\Mock\Request\MockRequestInterface;

class CreateRootWithoutDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var RootParagraphWithoutDeviceInterface */
    private $parsingResult;
    /** @var Exception */
    private $exception;
    /** @var CreateRootWithoutDeviceParser */
    private $createRootWithoutDeviceParser;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var array */
    private $data;

    /**
     * CreateRootWithoutDevice constructor.
     * @param CreateRootWithoutDeviceParserInterface $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(CreateRootWithoutDeviceParserInterface $parser, MockRequestInterface $mockRequest)
    {
        $this->createRootWithoutDeviceParser = $parser;
        $this->mockRequest = $mockRequest;
    }

    private function dataProvider()
    {
        return [
            "createParagraphRequest" => [
                "id" => "4e8c2b7c-9ab1-4121-94e1-ab075d2acf31",
                "title" => "Root paragraph without device",
                "sectionId" => "6647e03a-4f98-4a25-acc7-0ebad8fba229",
                "styleTemplateId" => "3a45f743-424c-4839-a395-ead0cd2e70c3"
            ]
        ];
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->data = $this->dataProvider();
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->data = ['wrongKey' => []];
    }

    /**
     * @Then Style Template Id should be default
     */
    public function styleTemplateIdShouldBeDefault()
    {
        /** @var StyleTemplateId $resultStyleTemplateId */
        $resultStyleTemplateId = $this->parsingResult->getStyleTemplateId();

        Assert::assertEquals($resultStyleTemplateId->getValue(), 'c11bbcc0-7862-4ffa-8669-586bca31e4c6');
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
     * @When I call method Parse
     */
    public function iCallMethodParse()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->data);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->parsingResult = $this->createRootWithoutDeviceParser->parse($mockRequest);
        } catch (InvalidArgumentException |
        FailCreateAction |
        InvalidParagraphIdException |
        FailCreateRootWithoutDevice |
        InvalidDeviceIdException |
        InvalidStyleTemplateIdException |
        InvalidSectionIdException
        $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get Command implements CreateRootWithoutDeviceInterface
     */
    public function iShouldGetCommandImplementsCreaterootwithoutdeviceinterface()
    {
        Assert::assertTrue($this->parsingResult instanceof CreateRootWithoutDeviceCommandInterface);
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
     * @Then Style HeaderType should be instance of NoHeaderInterface
     */
    public function styleHeadertypeShouldBeInstanceOfNoheaderinterface()
    {
        Assert::assertTrue($this->parsingResult->getHeader() instanceof NoHeaderInterface);
    }

    /**
     * @param $param
     * @Given param :param is empty
     */
    public function paramIsEmpty($param)
    {
        $this->data['createParagraphRequest'][$param] = '';
    }

}
