<?php

namespace App\Tests\Behat\Context\Item\Validator\PictureItem;

use Behat\Behat\Tester\Exception\PendingException;
use App\App\Command\Item\PictureItem\UpdatePictureItemCommandInterface;
use App\App\Command\Item\PictureItem\Validator\UpdatePictureItemValidatorInterface;
use App\Infrastructure\Parser\Item\PictureItem\UpdatePictureItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use App\Infrastructure\Exception\Item\FailUpdatePictureItem;

class UpdatePictureItemValidator implements Context
{
    /** @var UpdatePictureItemValidatorInterface */
    private $validator;

    /** @var UpdatePictureItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var array */
    private $errors;

    /** @var UpdatePictureItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /** @var \Exception */
    private $exception;

    public function __construct(UpdatePictureItemValidatorInterface $validator, UpdatePictureItemParserInterface $parser)
    {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData()
    {
        $this->requestData['updatePictureItem'] = [
            'id' => 'b825dbb7-c20e-44ce-b029-723338c0dbe6',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'photo',
            'label' => 'test update',
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
     * @When I call Update Picture Item Validator
     * @throws FailUpdatePictureItem
     */
    public function iCallUpdatePictureItemValidator()
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
        $this->requestData['updatePictureItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
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
     * @Given I'm set not exists param ItemId
     */
    public function imSetNotExistsParamItemid()
    {
        $this->requestData['updatePictureItem']['id'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     */
    public function imSetParamWithIncorrectValue($arg1)
    {
        $this->requestData['updatePictureItem'][$arg1] = '    ';
    }
}
