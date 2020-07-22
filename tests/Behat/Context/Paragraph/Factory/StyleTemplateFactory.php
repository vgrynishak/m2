<?php

namespace App\Tests\Behat\Context\Paragraph\Factory;

use App\App\Factory\Paragraph\StyleTemplateFactoryInterface;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class StyleTemplateFactory implements Context
{
    /** @var object */
    private $result;

    /** @var StyleTemplateFactoryInterface */
    private $factory;

    /** @var array */
    private $data;

    /**
     * StyleTemplateFactory constructor.
     * @param StyleTemplateFactoryInterface $factory
     */
    public function __construct(StyleTemplateFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @Given I'm Set Correct Params
     */
    public function imSetCorrectParams()
    {
        $this->data = [
            '3a45f743-424c-4839-a395-ead0cd2e70c3',
            'Test Template'
        ];
    }

    /**
     * @When I Call method Make
     */
    public function iCallMethodMake()
    {
        $this->result = $this->factory->make(...$this->data);
    }

    /**
     * @Then I should get StyleTemplate that Implements Paragraph StyleTemplate Interface
     */
    public function iShouldGetStyletemplateThatImplementsParagraphStyletemplateInterface()
    {
        Assert::assertTrue($this->result instanceof StyleTemplateInterface);
    }
}
