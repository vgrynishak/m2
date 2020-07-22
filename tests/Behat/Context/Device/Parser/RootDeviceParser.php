<?php

namespace App\Tests\Behat\Context\Device\Parser;

use App\Infrastructure\Parser\Device\RootDeviceParser as DeviceParser;
use App\App\Query\Device\FindByRootDeviceQuery;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use Exception;
use App\Infrastructure\ParamConverter\Device\DeviceIdConverter;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class RootDeviceParser implements Context
{
    /** @var array  */
    private $requestData = [];
    /** @var DeviceIdConverter */
    private $deviceIdConverter;
    /** @var Exception */
    private $exception;
    /** @var RootDeviceParser */
    private $rootDeviceParser;
    /** @var FindByRootDeviceQuery */
    private $parsingResult;

    /**
     * RootDeviceParser constructor.
     * @param DeviceIdConverter $converter
     * @param DeviceParser $parser
     */
    public function __construct(
        DeviceIdConverter $converter,
        DeviceParser $parser
    ) {
        $this->deviceIdConverter = $converter;
        $this->rootDeviceParser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData = [
            'deviceId' => "06fc2ed7-ba47-4efd-b421-c2880e4bed2c"
        ];
    }

    /**
     * @When I call RootDevice Parser
     */
    public function iCallRootdeviceParser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], [], $this->requestData);
            /** @var array $paramConverterData */
            $paramConverterData = [
                'name' => 'deviceId',
                'class' => 'App\Core\Model\Device\DeviceId',
                'isOptional' => false,
                'converter' => 'device_id.param_converter'
            ];
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->deviceIdConverter->apply($mockRequest, $paramConverter);
            $this->parsingResult = $this->rootDeviceParser->parse($mockRequest);
        } catch (InvalidDeviceIdException | FailGetListDevice | \InvalidArgumentException $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should get FindByRootDeviceQuery
     */
    public function iShouldGetFindByRootDeviceQuery(): void
    {
        if (!$this->parsingResult instanceof FindByRootDeviceQuery) {
            throw new Exception(
                'Parsing Result is not FindByRootDeviceQuery object.'
            );
        }
    }

    /**
     * @Given param :paramName is empty
     * @param $paramName
     */
    public function paramIsEmpty($paramName): void
    {
        unset($this->requestData[$paramName]);
    }

    /**
     * @Then I should get Exception :exceptionMessage
     * @param $exceptionMessage
     * @throws Exception
     */
    public function iShouldGetException($exceptionMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $exceptionMessage);

    }

    /**
     * @Given I'm set param :paramName with next value :paramValue
     * @param $paramName
     * @param $paramValue
     */
    public function imSetParamWithNextValue($paramName, $paramValue): void
    {
        $this->requestData[$paramName] = $paramValue;
    }
}