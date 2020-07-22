<?php

namespace App\Tests\Behat\Context\Section\Service;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Repository\Section\SectionQueryRepositoryInterface;
use App\Core\Service\Section\PositionIteratorInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class SectionPositionIterator implements Context
{
    /** @var int */
    private $result;
    /** @var PositionIteratorInterface */
    private $positionIterator;
    /** @var ReportTemplateId */
    private $reportTemplateId;
    /** @var SectionQueryRepositoryInterface */
    private $sectionQueryRepository;
    /** @var int */
    private $currentPosition;

    /**
     * SectionPositionIterator constructor.
     * @param PositionIteratorInterface $positionIterator
     * @param SectionQueryRepositoryInterface $sectionQueryRepository
     */
    public function __construct(
        PositionIteratorInterface $positionIterator,
        SectionQueryRepositoryInterface $sectionQueryRepository
    ) {
        $this->positionIterator = $positionIterator;
        $this->sectionQueryRepository = $sectionQueryRepository;
    }

    /**
     * @Given I'm set params
     */
    public function imSetParams()
    {
        $this->reportTemplateId = new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230');
        $this->currentPosition = $this->sectionQueryRepository->getMaxPosition($this->reportTemplateId);
    }

    /**
     * @When I call method next
     */
    public function iCallMethodNext()
    {
        $this->result = $this->positionIterator->next($this->reportTemplateId);
    }

    /**
     * @Then I should get increased position
     */
    public function iShouldGetIncreasedPosition()
    {
        Assert::assertEquals(++$this->currentPosition, $this->result);
    }
}
