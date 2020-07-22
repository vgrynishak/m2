<?php


namespace App\Tests\Behat\Context\Item\Parser\DeviceInformationItem;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\UpdateDeviceInformationItemCommandInterface;
use App\Infrastructure\Exception\Item\FailCreateDeviceInformationItem;
use App\Infrastructure\Exception\Item\FailUpdateDeviceInformationItem;
use App\Infrastructure\Parser\Item\DeviceInformationItem\CreateDeviceInformationItemParserInterface;
use App\Infrastructure\Parser\Item\DeviceInformationItem\UpdateDeviceInformationItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class UpdateDeviceInformationItem implements Context
{
    /** @var array */
    private $requestData;
    /** @var UpdateDeviceInformationItemParserInterface */
    private $parser;
    private $parsingResult;
    private $exception;

    /**
     * UpdateDeviceInformationItem constructor.
     * @param UpdateDeviceInformationItemParserInterface $parser
     */
    public function __construct(UpdateDeviceInformationItemParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['updateDeviceInformationItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'short_text_input',
            'label' => 'test',
            'infoSource' => [
                'infoSourceId' => 'backflow_size'
            ]
        ];
    }

    /**
     * @When I call UpdateDeviceInformationItemParser
     */
    public function iCallUpdatedeviceinformationitemparser()
    {
        try {
            /** @var Request $mockRequest */
            $request = new Request([], $this->requestData);

            $this->parsingResult = $this->parser->parse($request);
        } catch (FailUpdateDeviceInformationItem $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get UpdateDeviceInformationItemCommandInterface command
     */
    public function iShouldGetUpdatedeviceinformationitemcommandinterfaceCommand()
    {
        Assert::assertInstanceOf(UpdateDeviceInformationItemCommandInterface::class, $this->parsingResult);
    }

    /**
     * @Given param :arg1 is empty
     */
    public function paramIsEmpty($paramName)
    {
        unset($this->requestData['updateDeviceInformationItem'][$paramName]);
    }

    /**
     * @Then I should get Exception :arg1
     */
    public function iShouldGetException($exceptionMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception("There is no Exception");
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);
    }

    /**
     * @Given I'm create request with incorrect parent key
     */
    public function imCreateRequestWithIncorrectParentKey()
    {
        $this->requestData['incorrectKey'] = [
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'label' => 'test',
        ];
    }

    /**
     * @Given I'm set param :arg1 with next value :arg2
     */
    public function imSetParamWithNextValue($paramName, $paramValue)
    {
        $this->requestData['updateDeviceInformationItem'][$paramName] = $paramValue;
    }

    /**
     * @Given param :arg1 :arg2 is empty
     */
    public function paramIsEmpty2($paramObject, $paramValue)
    {
        unset($this->requestData['updateDeviceInformationItem'][$paramObject][$paramValue]);
    }
}
