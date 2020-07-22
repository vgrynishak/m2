<?php

namespace App\Tests\Behat\Context\Item\Validator\PictureItem;

use App\App\Command\Item\PictureItem\CreatePictureItemCommandInterface;
use App\App\Command\Item\PictureItem\Validator\CreatePictureItemValidatorInterface;
use App\Infrastructure\Parser\Item\PictureItem\CreatePictureItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Exception\Item\FailCreatePictureItem;
use InvalidArgumentException;

class CreatePictureItemValidator implements Context
{
    /** @var CreatePictureItemValidatorInterface */
    private $validator;

    /** @var CreatePictureItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var array */
    private $errors;

    /** @var CreatePictureItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /** @var \Exception */
    private $exception;

    public function __construct(CreatePictureItemValidatorInterface $validator, CreatePictureItemParserInterface $parser)
    {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createPictureItem'] = [
            'id' => '97196581-2ed6-4916-b642-f14e870b85b7',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'photo',
            'label' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
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
     * @When I call Create Picture Item Validator
     * @throws FailCreatePictureItem
     */
    public function iCallCreatePictureItemValidator()
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
        $this->requestData['createPictureItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :errorMessage
     * @param $errorMessage
     * @throws \Exception
     */
    public function iShouldGetMessageError($errorMessage)
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set param :paramName with incorrect value
     * @param $paramName
     */
    public function imSetParamWithIncorrectValue($paramName)
    {
        $this->requestData['createPictureItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set param :paramName value :paramValue with param remembered true
     * @param $paramName
     * @param $paramValue
     */
    public function imSetParamValueWithParamRememberedTrue($paramName, $paramValue)
    {
        $this->requestData['createPictureItem'][$paramName] = $paramValue;
    }
}
