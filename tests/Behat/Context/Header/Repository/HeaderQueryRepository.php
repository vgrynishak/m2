<?php

namespace App\Tests\Behat\Context\Header\Repository;

use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class HeaderQueryRepository implements Context
{
    /** @var HeaderQueryRepositoryInterface */
    private $headerQueryRepository;
    /** @var BaseHeaderInterface | null */
    private $result;
    /** @var ParagraphId */
    private $paragraphId;

    /**
     * HeaderQueryRepository constructor.
     * @param HeaderQueryRepositoryInterface $headerQueryRepository
     */
    public function __construct(HeaderQueryRepositoryInterface $headerQueryRepository)
    {
        $this->headerQueryRepository = $headerQueryRepository;
    }

    /**
     * @Given I'm Set correct ParagraphId
     */
    public function imSetCorrectParagraphid()
    {
        $this->paragraphId = new ParagraphId('7619baa9-6ec3-4c12-92e9-45cf6b03a11d');
    }

    /**
     * @When I Call Method find
     */
    public function iCallMethodFind()
    {
        $this->result = $this->headerQueryRepository->findByParagraphId($this->paragraphId);
    }

    /**
     * @Then I should get BaseHeaderInterface
     */
    public function iShouldGetBaseheaderinterface()
    {
        Assert::assertEquals($this->result instanceof BaseHeaderInterface, true);
    }
}
