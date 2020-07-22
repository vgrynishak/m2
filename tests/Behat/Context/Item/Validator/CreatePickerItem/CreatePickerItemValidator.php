<?php

namespace App\Tests\Behat\Context\Item\Validator\CreatePickerItem;

use App\App\Command\Item\PickerItem\CreatePickerItemCommandInterface;
use App\App\Command\Item\PickerItem\Validator\CreatePickerItemValidatorInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\PickerItem\CreatePickerItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CreatePickerItemValidator implements Context
{
    /** @var CreatePickerItemValidatorInterface */
    private $validator;

    /** @var CreatePickerItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var \Exception */
    private $exception;

    /** @var CreatePickerItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    public function __construct(CreatePickerItemValidatorInterface $validator, CreatePickerItemParserInterface $parser)
    {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createPickerItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::TIME_INTERVAL,
            'placeholder' => 'placeholder test',
            'label' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => false
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
     * @When I call CreatePickerItemValidator
     */
    public function iCallCreatepickeritemvalidator()
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
        $this->requestData['createPickerItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :arg1
     * @throws \Exception
     */
    public function iShouldGetMessageError($errorMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \RuntimeException('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     */
    public function imSetParamWithIncorrectValue($paramName)
    {
        $this->requestData['createPickerItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set param :arg1 without device and param remembered true
     */
    public function imSetParamWithoutDeviceAndParamRememberedTrue()
    {
        $this->requestData['createPickerItem']['remembered'] = true;
    }
}
