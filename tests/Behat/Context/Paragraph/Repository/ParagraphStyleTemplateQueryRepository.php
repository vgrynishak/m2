<?php

namespace App\Tests\Behat\Context\Paragraph\Repository;

use App\App\Repository\Paragraph\StyleTemplateQueryRepository;
use App\Core\Model\Exception\InvalidStyleTemplateIdException;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Paragraph\StyleTemplateInterface;
use App\Core\Repository\Paragraph\StyleTemplateQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ParagraphStyleTemplateQueryRepository implements Context
{
    /** @var StyleTemplateQueryRepositoryInterface */
    private $repository;

    /** @var StyleTemplateId */
    private $id;

    /** @var object */
    private $result;

    public function __construct(StyleTemplateQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @When I Call Method Find
     * @throws InvalidStyleTemplateIdException
     */
    public function iCallMethodFind()
    {
        $this->result = $this->repository->find(new StyleTemplateId($this->id));
    }

    /**
     * @Then I should get StyleTemplate that Implement Paragraph StyleTemplate Interface
     */
    public function iShouldGetStyletemplateThatImplementParagraphStyletemplateInterface()
    {
        Assert::assertTrue($this->result instanceof StyleTemplateInterface);
    }

    /**
     * @Given I'm Set param to find default StyleTemplate
     */
    public function imSetParamToFindDefaultStyletemplate()
    {
        $this->id = StyleTemplateQueryRepository::DEFAULT_TEMPLATE;
    }

    /**
     * @Given I'm Set correct param Id
     */
    public function imSetCorrectParamId()
    {
        $this->id = '3a45f743-424c-4839-a395-ead0cd2e70c3';
    }
}
