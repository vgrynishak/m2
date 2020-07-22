<?php

namespace App\Tests\Behat\Context\Item\Validator\SingleSelectList;

use App\App\Command\Item\ListItem\CreateListItemCommandInterface;
use App\App\Command\Item\ListItem\Validator\CreateListItemValidatorInterface;
use App\Core\Model\Item\ItemType\ItemType;
use App\Infrastructure\Parser\Item\ListItem\CreateListItemParserInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class SingleSelectListItemValidator implements Context
{
    /** @var CreateListItemValidatorInterface */
    private $validator;

    /** @var CreateListItemCommandInterface */
    private $command;

    /** @var bool */
    private $result;

    /** @var CreateListItemParserInterface */
    private $parser;

    /** @var array */
    private $requestData;

    /** @var \Exception */
    private $exception;

    /**
     * SingleSelectListItemValidator constructor.
     * @param CreateListItemValidatorInterface $validator
     * @param CreateListItemParserInterface $parser
     */
    public function __construct(CreateListItemValidatorInterface $validator, CreateListItemParserInterface $parser)
    {
        $this->validator = $validator;
        $this->parser = $parser;
    }

    private function prepareData()
    {
        $this->requestData['createListItem'] = [
            'id' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
            'paragraphId' => '63bea125-46f1-4d59-b6ec-13000d13ac9f',
            'itemTypeId' => ItemType::SINGLE_SELECTION_LIST,
            'label' => 'test',
            'answers' => [
                [
                    'answerId' => 'b65021f9-40fc-4b35-b3d2-9336d77b9c97',
                    'position' => 1,
                    'value' => 'Some default answer'
                ],
                [
                    'answerId' => 'e7c82207-59cf-460f-981c-a8d1a5fdd3fd',
                    'position' => 1,
                    'value' => 'Some answer 1',
                ],
                [
                    'answerId' => '97522594-1483-4fb6-aaa8-f2e452a3902e',
                    'position' => 1,
                    'value' => 'Some answer 2'
                ]
            ],
            'defaultAnswer' => [
                'answerId' => '97522594-1483-4fb6-aaa8-f2e452a3902e',
            ],
            'placeholder' => 'test',
            'NFPAref' => '1',
            'required' => false,
            'remembered' => true
        ];
    }

    /**
     * @Given I'm set correct params with itemTypeId single_select_list
     */
    public function imSetCorrectParamsWithItemTypeIdQuickSelect(): void
    {
        $this->prepareData();
    }

    /**
     * @When I call CreateListInputValidator
     */
    public function iCallCreateListInputValidator(): void
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
    public function iShouldGetTrueResult(): void
    {
        Assert::assertTrue($this->result);
    }

    /**
     * @Given I'm set not exists param paragraphId
     */
    public function imSetNotExistsParamParagraphId(): void
    {
        $this->requestData['createListItem']['paragraphId'] = '0bbf0559-aa83-4a2d-a54a-c1e80bd69cc5';
    }

    /**
     * @Then I should get message error :arg1
     * @param $errorMessage
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
     * @param $paramName
     */
    public function imSetParamWithIncorrectValue($paramName): void
    {
        $this->requestData['createListItem'][$paramName] = '    ';
    }

    /**
     * @Given I'm set answers less than :arg1
     */
    public function imSetAnswersMoreThan(): void
    {
        unset($this->requestData['createListItem']['answers'][0], $this->requestData['createListItem']['answers'][1]);
    }

    /**
     * @Given I'm set param answers[:arg1][value] with invalid length
     */
    public function imSetParamAnswersValueWithInvalidLength(): void
    {
        $this->requestData['createListItem']['answers'][0]['value'] = '        ';
    }

    /**
     * @Given I'm set duplicate answerId
     */
    public function imSetDuplicateAnswerId(): void
    {
        $this->requestData['createListItem']['answers'][1]['answerId'] = 'b65021f9-40fc-4b35-b3d2-9336d77b9c97';
    }

    /**
     * @Given I'm set defaultAnswerId negative assessment
     */
    public function imSetDefaultAnswerIdNegativeAssessment(): void
    {
        $this->requestData['createListItem']['answers'][2]['answerAssessment'] = 'negative';
    }
}
