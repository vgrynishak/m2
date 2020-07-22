<?php

namespace App\Tests\Behat\Context\ReportTemplate\Validator;

use App\App\Command\ReportTemplate\GetByIdCommand;
use App\App\Command\ReportTemplate\Validator\GetByIdValidatorInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class GetById implements Context
{
    /** @var array */
    private $commandParams = [];
    /** @var bool */
    private $result;
    /** @var GetByIdValidatorInterface */
    private $getByIdValidator;

    /**
     * GetById constructor.
     * @param GetByIdValidatorInterface $validator
     */
    public function __construct(GetByIdValidatorInterface $validator)
    {
        $this->getByIdValidator = $validator;
    }

    /**
     * @Given I'm set correct command params
     */
    public function imSetCorrectCommandParams()
    {
        $this->commandParams = [
            'reportTemplateId' => new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        ];
    }

    /**
     * @When I call GetByIdValidator
     */
    public function iCallGetbyidvalidator()
    {
        /** @var GetByIdCommand $getByIdCommand */
        $getByIdCommand = new GetByIdCommand($this->commandParams['reportTemplateId']);

        if ($this->getByIdValidator->validate($getByIdCommand)) {
            $this->result = true;
        } else {
            $this->result = $this->getByIdValidator->getFirstErrorMessage();
        }
    }

    /**
     * @Then I should get next positive result
     */
    public function iShouldGetNextPositiveResult()
    {
        Assert::assertEquals($this->result, true);
    }

    /**
     * @Given Report Template is not created
     */
    public function reportTemplateIsNotCreated()
    {
        $this->commandParams['reportTemplateId'] = new ReportTemplateId('63bea125-46f1-4d59-b6ec-13000d13ac9f');
    }

    /**
     * @param $errorMessage
     *
     * @Then I should get message error :arg1
     */
    public function iShouldGetMessageError($errorMessage)
    {
        Assert::assertEquals($this->result, $errorMessage);
    }
}
