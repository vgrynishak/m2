<?php

namespace App\Tests\Behat\Context\Section\Factory;

use App\App\Command\Section\CreateSectionCommand;
use App\App\Factory\Section\SectionFactoryInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Section\SectionInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class SectionFactory implements Context
{
    /** @var SectionInterface */
    private $result;
    /** @var SectionFactoryInterface */
    private $factory;
    /** @var CreateSectionCommand */
    private $command;

    /**
     * SectionFactory constructor.
     * @param SectionFactoryInterface $factory
     */
    public function __construct(SectionFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @Given I'm Set Correct CreateSectionCommandInterface
     */
    public function imSetCorrectCreatesectioncommandinterface()
    {
        $this->command = new CreateSectionCommand(
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba229'),
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230'),
            'title'
        );
    }

    /**
     * @When I Call method MakeByCommand
     */
    public function iCallMethodMakebycommand()
    {
        $this->result = $this->factory->makeByCommand($this->command);
    }

    /**
     * @Then I should get SectionInterface
     */
    public function iShouldGetSectioninterface()
    {
        Assert::assertTrue($this->result instanceof SectionInterface);
    }
}
