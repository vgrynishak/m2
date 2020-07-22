<?php

namespace App\Tests\Behat\Context\Item\Repository;

use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Item\ItemQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use PhpCollection\CollectionInterface;
use PHPUnit\Framework\Assert;

class ItemQueryRepository implements Context
{
    /** @var ItemQueryRepositoryInterface */
    private $repository;

    /** @var ParagraphId */
    private $paragraphId;

    /** @var CollectionInterface */
    private $result;

    public function __construct(ItemQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Given I'm Set correct ParagraphId
     */
    public function imSetCorrectParagraphid()
    {
        $this->paragraphId = new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d');
    }

    /**
     * @When I Call Method findListByParagraphId
     */
    public function iCallMethodFindlistbyparagraphid()
    {
        $this->result = $this->repository->findListByParagraphId($this->paragraphId);
    }

    /**
     * @Then I should get Collection Interface
     */
    public function iShouldGetCollectionInterface()
    {
        Assert::assertInstanceOf(CollectionInterface::class, $this->result);
    }
}
