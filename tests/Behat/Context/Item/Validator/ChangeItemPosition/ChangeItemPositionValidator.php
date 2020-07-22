<?php

namespace App\Tests\Behat\Context\Item\Validator\ChangeItemPosition;

use App\App\Command\Item\ChangeItemPosition\ChangeItemPositionCommandInterface;
use App\App\Command\Item\ChangeItemPosition\Validator\ChangeItemPositionValidatorInterface;
use App\Infrastructure\Parser\Item\ChangeItemPosition\ChangeItemPositionParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class ChangeItemPositionValidator implements Context
{
    /** @var ChangeItemPositionParserInterface */
    private $parser;

    /** @var ChangeItemPositionValidatorInterface */
    private $validator;

    /** @var array */
    private $requestData;

    /** @var \Exception */
    private $exception;

    /** @var ChangeItemPositionCommandInterface */
    private $command;

    private $result;
    /**
     * ChangeItemPositionValidator constructor.
     * @param ChangeItemPositionParserInterface $parser
     * @param ChangeItemPositionValidatorInterface $validator
     */
    public function __construct(
        ChangeItemPositionParserInterface $parser,
        ChangeItemPositionValidatorInterface $validator
    ) {
        $this->parser = $parser;
        $this->validator = $validator;
    }

    private function prepareData()
    {
        $this->requestData['changeItemPositionRequest'] = [
            'id' => 'b825dbb7-c20e-44ce-b029-723338c0dbe6',
            'newPosition' => 2,
        ];
    }

    /**
     * @Given I'm set correct command params
     */
    public function imSetCorrectCommandParams()
    {
        $this->prepareData();
    }

    /**
     * @When I call ChangeItemPositionValidator
     */
    public function iCallChangeitempositionvalidator()
    {
        $request = new Request([], $this->requestData);
        $this->command = $this->parser->parse($request);

        try {
            $this->result = $this->validator->validate($this->command);
        } catch (\InvalidArgumentException $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should get true result
     */
    public function iShouldGetTrueResult()
    {
        Assert::assertSame($this->result, true);
    }

    /**
     * @Given Item with id is not exist
     */
    public function itemWithIdIsNotExist()
    {
        $this->requestData['changeItemPositionRequest']['id'] = '7619baa9-6ec3-4c12-92e9-45cf6b03a11d';
    }

    /**
     * @Then I should get message error :arg1
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
     * @Given Param newPosition is :arg1
     */
    public function paramNewPositionIs($arg1)
    {
        $this->requestData['changeItemPositionRequest']['newPosition'] = $arg1;
    }
}
