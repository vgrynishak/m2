<?php

namespace App\Tests\Behat\Context\Item\Validator\DeviceInformation;

use App\App\Command\Item\DeviceInformationItem\CreateDeviceInformationItemCommandInterface;
use App\App\Command\Item\DeviceInformationItem\Validator\CreateDeviceInformationItemValidatorInterface;
use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\DeviceInformationItem\CreateDeviceInformationItemParserInterface;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreateDeviceInformationItemValidator implements Context
{
    /** @var CreateDeviceInformationItemValidatorInterface */
    private $validator;

    /** @var CreateInputItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var Exception */
    private $exception;

    /** @var CreateDeviceInformationItemCommandInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /**
     * CreateDeviceInformationItemValidator constructor.
     * @param CreateDeviceInformationItemValidatorInterface $validator
     * @param CreateDeviceInformationItemParserInterface $parser
     */
    public function __construct(
        CreateDeviceInformationItemValidatorInterface $validator,
        CreateDeviceInformationItemParserInterface $parser
    ) {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createDeviceInformationItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::INFORMATION_DEVICE_RELATED,
            'label' => 'test',
            'infoSource' => [
                'infoSourceId' => 'backflow_size',
            ],
        ];
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams()
    {
        $this->prepareData();
    }

    /**
     * @When I call Create DeviceInformation Item Validator
     */
    public function iCallCreateDeviceinformationItemValidator()
    {
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);

        try {
            $this->result = $this->validator->validate($this->command);
        } catch (InvalidArgumentException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get true result
     */
    public function iShouldGetTrueResult()
    {
        Assert::assertTrue($this->result);
    }

    /**
     * @Given I'm set not exists param paragraphId
     */
    public function imSetNotExistsParamParagraphid()
    {
        $this->requestData['createDeviceInformationItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :arg1
     */
    public function iShouldGetMessageError($errorMessage)
    {
        if (!$this->exception instanceof Exception) {
            throw new Exception('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     */
    public function imSetParamWithIncorrectValue($paramName)
    {
        $this->requestData['createDeviceInformationItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set not exists param infoSource
     */
    public function imSetNotExistsParamInfosource()
    {
        $this->requestData['createDeviceInformationItem']['infoSource']['infoSourceId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }
}
