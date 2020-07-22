<?php
namespace App\Tests\Behat\Context\Paragraph\Service;

use App\App\Factory\Paragraph\ParagraphFactoryInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Exception\InvalidDeviceIdException;
use App\Core\Model\Exception\InvalidParagraphFilterIdException;
use App\Core\Model\Exception\InvalidParagraphIdException;
use App\Core\Model\Exception\InvalidSectionIdException;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphQueryRepositoryInterface;
use App\Core\Service\Paragraph\PositionIteratorInterface;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class IterateParagraphPosition implements Context
{
    /** @var PositionIteratorInterface */
    private $iterator;
    /** @var BaseParagraphInterface */
    private $paragraph;
    /** @var int */
    private $result;
    /** @var ParagraphQueryRepositoryInterface */
    private $paragraphQueryRepository;
    /** @var ParagraphFactoryInterface */
    private $paragraphFactory;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;
    /** @var HeaderQueryRepositoryInterface */
    private $headerQueryRepository;

    /**
     * IterateParagraphPosition constructor.
     * @param PositionIteratorInterface $iterator
     * @param ParagraphQueryRepositoryInterface $paragraphQueryRepository
     * @param ParagraphFactoryInterface $paragraphFactory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     * @param HeaderQueryRepositoryInterface $headerQueryRepository
     */
    public function __construct(
        PositionIteratorInterface $iterator,
        ParagraphQueryRepositoryInterface $paragraphQueryRepository,
        ParagraphFactoryInterface $paragraphFactory,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        HeaderQueryRepositoryInterface $headerQueryRepository
    ) {
        $this->iterator = $iterator;
        $this->paragraphQueryRepository = $paragraphQueryRepository;
        $this->paragraphFactory = $paragraphFactory;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->headerQueryRepository = $headerQueryRepository;
    }

    /**
     * @param string $id
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    private function createParagraph(string $id, string $section)
    {
        /** @var DeviceInterface $device */
        $device = $this->deviceQueryRepository->find(new DeviceId('63bea125-46f1-4d59-b6ec-65000d13ac1f'));
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find(new ParagraphFilterId('inspection'));
        /** @var BaseHeaderInterface $header */
        $header =
            $this->headerQueryRepository->findByParagraphId(new ParagraphId("63bea125-46f1-4d59-b6ec-13000d13ac9f"));

        /** @var RootParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->paragraphFactory->makeRootWithDevice(
            new ParagraphId($id),
            new SectionId($section),
            $device,
            $filter,
            $header
        );

        $this->paragraph = $paragraph;
    }

    /**
     * @Given I’m set first Paragraph in Section
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    public function imSetFirstParagraphInSection()
    {
        $this->createParagraph('06304270-13dc-4826-9f04-c3be7dae4638', '0f016e65-748f-4d23-9a85-af7d163576b9');
    }

    /**
     * @When I call Method Next
     */
    public function iCallMethodNext()
    {
        $this->result = $this->iterator->next($this->paragraph);
    }

    /**
     * @Given I’m set new Paragraph in Section that have last paragraph with position
     * @throws InvalidDeviceIdException
     * @throws InvalidParagraphFilterIdException
     * @throws InvalidParagraphIdException
     * @throws InvalidSectionIdException
     */
    public function imSetNewParagraphInSectionThatHaveLastParagraphWithPosition()
    {
        $this->createParagraph('fffdf196-8af2-4cc5-bad0-aab27e581aa0', '6647e03a-4f98-4a25-acc7-0ebad8fba229');
    }

    /**
     * @Then I should get Position :position
     * @param $position
     */
    public function iShouldGetPosition($position)
    {
        Assert::assertEquals($this->result, $position);
    }
}
