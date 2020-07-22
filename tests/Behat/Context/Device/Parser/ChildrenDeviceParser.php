<?php


namespace App\Tests\Behat\Context\Device\Parser;

use App\Infrastructure\Parser\Device\ChildrenDeviceParser as DeviceParser;
use App\App\Query\Device\FindByChildrenDeviceQuery;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Infrastructure\Exception\Device\FailGetListDevice;
use App\Infrastructure\ParamConverter\Device\DeviceIdConverter;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ChildrenDeviceParser implements Context
{
    /** @var array  */
    private $requestData = [];
    /** @var DeviceIdConverter */
    private $deviceIdConverter;
    /** @var \Exception */
    private $exception;
    /** @var ChildrenDeviceParser */
    private $childrenDeviceParser;
    /** @var FindByChildrenDeviceQuery */
    private $parsingResult;
    /** @var array */
    private $postData = [];

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
        $this->childrenDeviceParser = $parser;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->postData['getListForChildrenParagraph'] = [
            'groupId' => 'related_to_inspected_device'
        ];
        $this->requestData = [
            'deviceId' => "06fc2ed7-ba47-4efd-b421-c2880e4bed2c"
        ];
    }

    /**
     * @When I call ChildrenDevice Parser
     */
    public function iCallChildrendeviceParser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], $this->postData, $this->requestData);
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
            $this->parsingResult = $this->childrenDeviceParser->parse($mockRequest);
        } catch (InvalidDeviceIdException | FailGetListDevice | \InvalidArgumentException $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should get FindByChildrenDeviceQuery
     */
    public function iShouldGetFindBycDeviceQuery(): void
    {
        if (!$this->parsingResult instanceof FindByChildrenDeviceQuery) {
            throw new \Exception(
                'Parsing Result is not FindByChildrenDeviceQuery object.'
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
     * @throws \Exception
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

    /**
     * @Given param root key is empty
     */
    public function paramRootKeyIsEmpty()
    {
        unset($this->postData['getListForChildrenParagraph']);
    }

    /**
     * @Given param groupId  is empty
     */
    public function paramGroupidIsEmpty()
    {
        unset($this->postData['getListForChildrenParagraph']['groupId']);
    }
}
