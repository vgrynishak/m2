<?php

namespace App\Tests\Behat\Context\Item\Validator\LongTextInput;

use App\App\Command\Item\InputItem\CreateInputItemCommandInterface;
use App\App\Command\Item\InputItem\Validator\CreateInputItemValidatorInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\InputItem\CreateInputItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class LongTextInputValidator implements Context
{
    /** @var CreateInputItemValidatorInterface */
    private $validator;

    /** @var CreateInputItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var \Exception */
    private $exception;

    /** @var CreateInputItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    public function __construct(CreateInputItemValidatorInterface $validator, CreateInputItemParserInterface $parser)
    {
        $this->validator    = $validator;
        $this->parser       = $parser;
    }

    private function prepareData(): void
    {
        $this->requestData['createInputItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::LONG_TEXT_INPUT,
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
     * @Given I'm set correct params with itemTypeId long_text_input
     */
    public function imSetCorrectParamsWithItemTypeIdLongTextInput(): void
    {
        $this->prepareData();
    }

    /**
     * @When I call CreateInputItemValidator
     */
    public function iCallCreateInputItemValidator(): void
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
        $this->requestData['createInputItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
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
     */
    public function imSetParamWithIncorrectValue($paramName): void
    {
        $this->requestData['createInputItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set param defaultAnswer[value] with incorrect value
     */
    public function imSetParamDefaultAnswerValueWithIncorrectValue(): void
    {
        $this->requestData['createInputItem']['defaultAnswer']['value'] = '    ';
    }

    /**
     * @Given I'm set param defaultAnswer[AnswerAssessment] with incorrect value
     */
    public function imSetParamDefaultAnswerAnswerAssessmentWithIncorrectValue(): void
    {
        $this->requestData['createInputItem']['defaultAnswer']['answerAssessment'] = 'negative';
    }
}
