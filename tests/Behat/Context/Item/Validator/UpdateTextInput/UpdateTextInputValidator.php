<?php

namespace App\Tests\Behat\Context\Item\Validator\UpdateTextInput;

use App\App\Command\Item\InputItem\UpdateInputItemCommandInterface;
use App\App\Command\Item\InputItem\Validator\UpdateInputItemValidatorInterface;
use App\Infrastructure\Parser\Item\InputItem\UpdateInputItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class UpdateTextInputValidator implements Context
{
    /** @var UpdateInputItemValidatorInterface */
    private $validator;

    /** @var UpdateInputItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var \Exception */
    private $exception;

    /** @var UpdateInputItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    public function __construct(UpdateInputItemValidatorInterface $validator, UpdateInputItemParserInterface $parser)
    {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData()
    {
        $this->requestData['updateInputItem'] = [
            'id' => '63bea125-46f1-4d59-b6ec-65000d13ac1a',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => 'short_text_input',
            'label' => 'test',
            'defaultAnswer' => [
                'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                'position' => 1,
                'value' => 'Some default answer',
                'answerAssessment' => 'none'
            ],
            'placeholder' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
        ];
    }

    /**
     * @Given I'm set correct params
     */
    public function imSetCorrectParams(): void
    {
        $this->prepareData();
    }

    /**
     * @When I call UpdateInputItemValidator
     */
    public function iCallCreateTextInputValidator(): void
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
    public function iShouldGetTrueResult(): void
    {
        Assert::assertTrue($this->result);
    }

    /**
     * @Given I'm set not exists param paragraphId
     */
    public function imSetNotExistsParamParagraphId(): void
    {
        $this->requestData['updateInputItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :arg1
     * @param $errorMessage
     * @throws \Exception
     */
    public function iShouldGetMessageError($errorMessage): void
    {
        if (!$this->exception instanceof \Exception) {
            throw new \Exception('There is no Exception');
        }

        Assert::assertEquals($this->exception->getMessage(), $errorMessage);
    }

    /**
     * @Given I'm set param :arg1 with incorrect value
     * @param $paramName
     */
    public function imSetParamWithIncorrectValue($paramName): void
    {
        $this->requestData['updateInputItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set param defaultAnswer[value] with incorrect value
     */
    public function imSetParamDefaultAnswerValueWithIncorrectValue(): void
    {
        $this->requestData['updateInputItem']['defaultAnswer']['value'] = '    ';
    }

    /**
     * @Given I'm set param defaultAnswer[AnswerAssessment] with incorrect value
     */
    public function imSetParamDefaultAnswerAnswerAssessmentWithIncorrectValue(): void
    {
        $this->requestData['updateInputItem']['defaultAnswer']['answerAssessment'] = 'negative';
    }

    /**
     * @Given I'm set not exists param ItemId
     */
    public function imSetNotExistsParamItemid()
    {
        $this->requestData['updateInputItem']['id'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }
}
