<?php

namespace App\Tests\Behat\Context\Paragraph\Service;

use App\App\Factory\Paragraph\ParagraphFactoryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Paragraph\ChildParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Section\SectionId;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use App\Core\Service\Paragraph\LevelIteratorInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class IterateParagraphLevel implements Context
{
    /** @var int */
    private $result;
    /** @var LevelIteratorInterface */
    private $iterator;
    /** @var string */
    private $parentId;
    /** @var ParagraphFactoryInterface */
    private $factory;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;
    /** @var HeaderQueryRepositoryInterface */
    private $headerQueryRepository;

    /**
     * IterateParagraphLevel constructor.
     * @param LevelIteratorInterface $iterator
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ParagraphFactoryInterface $factory
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     * @param HeaderQueryRepositoryInterface $headerQueryRepository
     */
    public function __construct(
        LevelIteratorInterface $iterator,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFactoryInterface $factory,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        HeaderQueryRepositoryInterface $headerQueryRepository
    ) {
        $this->iterator = $iterator;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->factory = $factory;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->headerQueryRepository = $headerQueryRepository;
    }

    /**
     * @Given I’m set child Paragraph with Parent Root Paragraph
     */
    public function imSetChildParagraphWithParentRootParagraph()
    {
        $this->parentId = '63bea125-46f1-4d59-b6ec-13000d13ac9f';
    }

    /**
     * @Given I’m set child Paragraph with Parent Child Paragraph
     */
    public function imSetChildParagraphWithParentChildParagraph()
    {
        $this->parentId = 'd1a01008-d6e0-4b6f-9d40-f68f91a34b65';
    }

    /**
     * @When I call Method Next
     * @throws InvalidParagraphIdException
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidSectionIdException
     */
    public function iCallMethodNext()
    {
        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find(new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'));
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find(new ParagraphFilterId('inspection'));
        /** @var ParagraphId $paragraphId */
        $paragraphId = new ParagraphId('d1a01008-d6e0-4b6f-9d40-f68f91a34b65');
        /** @var BaseHeaderInterface $header */
        $header = $this->headerQueryRepository->findByParagraphId($paragraphId);

        /** @var ChildParagraphInterface $paragraph */
        $paragraph = $this->factory->makeChildWithDevice(
            $paragraphId,
            new ParagraphId($this->parentId),
            new SectionId('6647e03a-4f98-4a25-acc7-0ebad8fba229'),
            $device,
            $filter,
            $header
        );

        $paragraph->setPrintable(1);
        $paragraph->setPosition(2);

        $this->result = $this->iterator->next($paragraph);
    }

    /**
     * @Then I should get Level :level
     * @param $level
     */
    public function iShouldGetLevel($level)
    {
        Assert::assertEquals($this->result, $level);
    }
}
