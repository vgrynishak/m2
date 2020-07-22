<?php

namespace App\Tests\Behat\Context\Paragraph\Repository;

use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ParagraphFilterQueryRepository implements Context
{
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $repository;

    /** @var ParagraphFilterId */
    private $paragraphFilterId;

    /** @var ParagraphFilterInterface */
    private $result;

    /**
     * ParagraphFilterQueryRepository constructor.
     * @param ParagraphFilterQueryRepositoryInterface $repository
     */
    public function __construct(ParagraphFilterQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Given I'm Set param :alias
     * @param $alias
     * @throws InvalidParagraphFilterIdException
     */
    public function imSetParam($alias)
    {
        $this->paragraphFilterId = new ParagraphFilterId($alias);
    }

    /**
     * @Then I should get Filter that Implement Paragraph Filter Interface
     */
    public function iShouldGetFilterThatImplementParagraphFilterInterface()
    {
        Assert::assertTrue($this->result instanceof ParagraphFilterInterface);
    }

    /**
     * @Given I'm Set incorrect param :alias
     * @param $alias
     * @throws InvalidParagraphFilterIdException
     */
    public function imSetIncorrectParam($alias)
    {
        $this->paragraphFilterId = new ParagraphFilterId($alias);
    }

    /**
     * @Then I should get null result
     */
    public function iShouldGetNullResult()
    {
        Assert::assertEquals($this->result, null);
    }

    /**
     * @Then property Id should be :alias
     * @param $alias
     */
    public function propertyIdShouldBe($alias)
    {
        Assert::assertEquals($this->result->getId()->getValue(), $alias);
    }

    /**
     * @When I Call Method Find
     */
    public function iCallMethodFind()
    {
        $this->result = $this->repository->find($this->paragraphFilterId);
    }
}
