<?php

namespace App\Tests\Behat\Context\Item\Service;

use App\App\Repository\Item\ItemQueryRepository;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Service\Item\PositionIteratorInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class ItemPositionIterator implements Context
{
    /** @var int */
    private $currentPosition;
    /** @var ParagraphId */
    private $paragraphId;
    /** @var ItemQueryRepository */
    private $itemRepository;
    /** @var PositionIteratorInterface */
    private $iterator;
    /** @var int */
    private $result;

    public function __construct(PositionIteratorInterface $iterator, ItemQueryRepository $itemRepository)
    {
        $this->iterator = $iterator;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @Given I'm set params
     */
    public function imSetParams()
    {
        $this->paragraphId = new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d');
        $this->currentPosition = $this->itemRepository->getMaxPosition($this->paragraphId);
    }

    /**
     * @When I call method next
     */
    public function iCallMethodNext()
    {
        $this->result = $this->iterator->next($this->paragraphId);
    }

    /**
     * @Then I should get increased position
     */
    public function iShouldGetIncreasedPosition()
    {
        Assert::assertEquals(++$this->currentPosition, $this->result);
    }
}