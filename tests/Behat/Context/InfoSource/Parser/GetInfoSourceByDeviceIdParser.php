<?php

namespace App\Tests\Behat\Context\InfoSource\Parser;

use App\App\Component\Mock\Request\MockRequestInterface;
use App\App\Query\InfoSource\InfoSourceListByDictionaryIdQueryInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidDictionaryIdException;
use App\Infrastructure\Exception\InfoSource\FailGetInfoSourceListByDictionaryId;
use App\Infrastructure\ParamConverter\Device\DeviceIdConverterInterface;
use App\Infrastructure\ParamConverter\Dictionary\DictionaryIdConverterInterface;
use App\Infrastructure\Parser\InfoSource\InfoSourceListByDictionaryIdParserInterface;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Behat\Behat\Context\Context;

class GetInfoSourceByDeviceIdParser implements Context
{
    private const ADMIN_USER_EMAIL = 'admin@test.com';

    /** @var array  */
    private $requestData = [];
    /** @var Exception */
    private $exception;
    /** @var MockRequestInterface */
    private $mockRequest;
    /** @var DictionaryIdConverterInterface */
    private $dictionaryIdConverter;
    /** @var InfoSourceListByDictionaryIdParserInterface */
    private $getDeviceDynamicFieldListByDeviceIdParser;
    /** @var InfoSourceListByDictionaryIdQueryInterface */
    private $parsingResult;

    /**
     * GetInfoSourceByDeviceIdParser constructor.
     * @param InfoSourceListByDictionaryIdParserInterface $getDeviceDynamicFieldListByDeviceIdParser
     * @param DictionaryIdConverterInterface $converter
     * @param MockRequestInterface $mockRequest
     */
    public function __construct(
        InfoSourceListByDictionaryIdParserInterface $getDeviceDynamicFieldListByDeviceIdParser,
        DictionaryIdConverterInterface $converter,
        MockRequestInterface $mockRequest
    ) {
        $this->getDeviceDynamicFieldListByDeviceIdParser = $getDeviceDynamicFieldListByDeviceIdParser;
        $this->dictionaryIdConverter = $converter;
        $this->mockRequest = $mockRequest;
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->requestData['dictionaryId'] = "a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015";
    }

    /**
     * @When I call GetDeviceDynamicFieldListByDeviceIdParser
     */
    public function iCallGetdevicedynamicfieldlistbydeviceidparser()
    {
        try {
            /** @var Request $mockRequest */
            $mockRequest = new Request([], [], $this->requestData);
            /** @var array $paramConverterData */
            $paramConverterData = [
                'name' => 'dictionaryId',
                'class' => 'App\Core\Model\Item\InformationItem\Dictionary\DictionaryId',
                'isOptional' => false,
                'converter' => 'dictionary_id.param_converter'
            ];
            $this->mockRequest->pushRequestByUserEmail($mockRequest, self::ADMIN_USER_EMAIL);
            /** @var ParamConverter $paramConverter */
            $paramConverter = new ParamConverter($paramConverterData);
            $this->dictionaryIdConverter->apply($mockRequest, $paramConverter);

            $this->parsingResult = $this->getDeviceDynamicFieldListByDeviceIdParser->parse($mockRequest);
        } catch (InvalidDictionaryIdException |
        FailGetInfoSourceListByDictionaryId |
        InvalidArgumentException $exception
        ) {
            $this->exception = $exception;
        }
    }

    /**
     * @throws Exception
     * @Then I should get GetDeviceDynamicFieldListByDeviceIdParserInterface
     */
    public function iShouldGetGetdevicedynamicfieldlistbydeviceidparserinterface()
    {
        if (!$this->parsingResult instanceof InfoSourceListByDictionaryIdQueryInterface) {
            throw new Exception(
                "Parsing Result is not GetDeviceDynamicFieldListByDeviceIdCommand object."
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
