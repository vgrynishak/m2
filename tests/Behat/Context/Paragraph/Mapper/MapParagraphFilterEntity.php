<?php

namespace App\Tests\Behat\Context\Paragraph\Mapper;

use App\App\Doctrine\Entity\ParagraphFilter;
use App\App\Doctrine\Repository\ParagraphFilterRepository;
use App\App\Mapper\Paragraph\ParagraphFilterEntityMapperInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class MapParagraphFilterEntity implements Context
{
    /** @var ParagraphFilterRepository */
    private $paragraphFilterRepository;

    /** @var ParagraphFilter */
    private $paragraphFilterORM;

    /** @var ParagraphFilterEntityMapperInterface */
    private $mapper;

    /** @var object */
    private $result;

    /**
     * MapParagraphFilterEntity constructor.
     * @param ParagraphFilterRepository $paragraphFilterRepository
     * @param ParagraphFilterEntityMapperInterface $mapper
     */
    public function __construct(
        ParagraphFilterRepository $paragraphFilterRepository,
        ParagraphFilterEntityMapperInterface $mapper
    ) {
        $this->paragraphFilterRepository = $paragraphFilterRepository;
        $this->mapper = $mapper;
    }

    /**
     * @Given I’m set ParagraphFilter Entity with id :alias
     * @param $alias
     */
    public function imSetParagraphfilterEntityWithId($alias)
    {
        $this->paragraphFilterORM = $this->paragraphFilterRepository->find($alias);
    }

    /**
     * @When I call ParagraphFilterEntityMapper
     */
    public function iCallParagraphfilterentitymapper()
    {
        $this->result = $this->mapper->map($this->paragraphFilterORM);
    }

    /**
     * @Then I should get Filter that Implement Paragraph Filter Interface
     */
    public function iShouldGetFilterThatImplementParagraphFilterInterface()
    {
        Assert::assertTrue($this->result instanceof ParagraphFilterInterface);
    }

    /**
     * @Then Filter Id Value equal :alias
     * @param $alias
     */
    public function filterIdValueEqual($alias)
    {
        Assert::assertEquals($this->result->getId()->getValue(), $alias);
    }
}
