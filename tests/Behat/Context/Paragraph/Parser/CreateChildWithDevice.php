<?php

namespace App\Tests\Behat\Context\Paragraph\Parser;

use App\Core\Model\Paragraph\Header\CustomHeaderInterface;
use App\Core\Model\Paragraph\Header\DeviceCardHeaderInterface;
use App\App\Command\Paragraph\CreateChildWithDeviceCommandInterface;
use App\App\Component\Mock\Request\MockRequestInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Infrastructure\Exception\Paragraph\FailCreateAction;
use App\Infrastructure\Parser\Paragraph\CreateChildWithDeviceParser;
use Behat\Behat\Context\Context;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class CreateChildWithDevice implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array */
    private $data;

    /** @var CreateChildWithDeviceCommandInterface */
    private $result;

    /** @var Exception */
    private $exception;

    /** @var CreateChildWithDeviceParser */
    private $createChildWithDeviceParser;

    /** @var MockRequestInterface */
    private $mockRequest;

    /**
     * CreateChildWithDevice constructor.
     * @param CreateChildWithDeviceParser $parser
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        CreateChildWithDeviceParser $parser,
        MockRequestInterface $mockRequest
    ) {
        $this->createChildWithDeviceParser = $parser;
        $this->mockRequest = $mockRequest;
    }

    private function childWithDeviceDataProvider()
    {
        return [
            "createParagraphRequest" => [
                "id" => "3e0ff516-217f-4de6-a30e-3f2e6f019646",
                "title" => "Child paragraph with device",
                "parentId" => "d1a01008-d6e0-4b6f-9d40-f68f91a34b65",
                "deviceId" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
                "filterId" => "on_site",
                "styleTemplateId" => "3a45f743-424c-4839-a395-ead0cd2e70c3"
            ]
        ];
    }

    /**
     * @When I call CreateChildWithDeviceParser
     */
    public function iCallCreatechildwithdeviceparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->data);
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);

            $this->result = $this->createChildWithDeviceParser->parse($mockRequest);
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
        $this->data = ['wrongKey' => []];
    }

    /**
     * @Given I'm set param :param with incorrect value
     * @param $param
     */
    public function imSetParamWithIncorrectValue($param)
    {
        if ($param == 'filterId') {
            $this->data['createParagraphRequest'][$param] = 'Wrooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
        oooooooooooooooooooooooooooooooooooooooooooooongParam';
        } else {
            $this->data['createParagraphRequest'][$param] = 'wrongParam';
        }
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
     * @Given I'm set not exists param parentId
     */
    public function imSetNotExistsParamParentid()
    {
        $this->data['createParagraphRequest']['parentId'] = '66787382-20c7-4919-a013-b99e6b5ed36a';
    }

    /**
     * @Then Style Template Id should be default
     */
    public function styleTemplateIdShouldBeDefault()
    {
        /** @var StyleTemplateId $resultStyleTemplateId */
        $resultStyleTemplateId = $this->result->getStyleTemplateId();

        Assert::assertEquals($resultStyleTemplateId->getValue(), '3a45f743-424c-4839-a395-ead0cd2e70c3');
    }

    /**
     * @Then I should get CreateChildWithDevice command
     */
    public function iShouldGetCreatechildwithdeviceCommand()
    {
        Assert::assertTrue($this->result instanceof CreateChildWithDeviceCommandInterface);
    }

    /**
     * @Then property header should be instance of CustomHeaderInterface
     */
    public function propertyHeaderShouldBeInstanceOfCustomheaderinterface()
    {
        Assert::assertTrue($this->result->getHeader() instanceof CustomHeaderInterface);
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
        Assert::assertTrue($this->result->getHeader() instanceof DeviceCardHeaderInterface);
    }
}
