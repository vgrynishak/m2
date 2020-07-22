<?php

namespace App\Tests\Behat\Context\Paragraph\Factory;

use App\App\Factory\Paragraph\ParagraphFilterFactoryInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ParagraphFilterFactory implements Context
{
    /** @var ParagraphFilterFactoryInterface */
    private $factory;

    /** @var ParagraphFilterInterface */
    private $result;

    /** @var string */
    private $alias;

    /**
     * ParagraphFilterFactory constructor.
     * @param ParagraphFilterFactoryInterface $factory
     */
    public function __construct(ParagraphFilterFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @Given I'm Set Correct Params
     */
    public function imSetCorrectParams()
    {
        $this->alias = 'on_site';
    }

    /**
     * @When I Call ParagraphFilterFactory
     */
    public function iCallParagraphfilterfactory()
    {
        $this->result = $this->factory->make($this->alias, 'By Facility');
    }

    /**
     * @Then I should get Filter that Implement Paragraph Filter Interface
     */
    public function iShouldGetFilterThatImplementParagraphFilterInterface()
    {
        Assert::assertTrue($this->result instanceof ParagraphFilterInterface);
    }
}
