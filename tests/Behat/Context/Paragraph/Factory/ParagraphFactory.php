<?php

namespace App\Tests\Behat\Context\Paragraph\Factory;

use App\App\Factory\Paragraph\ParagraphFactoryInterface;
use App\Core\Model\Device\Device;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Repository\Device\DeviceQueryRepositoryInterface;
use App\Core\Repository\Paragraph\HeaderQueryRepositoryInterface;
use App\Core\Repository\Paragraph\ParagraphFilterQueryRepositoryInterface;
use Behat\Behat\Context\Context;
use Exception;
use PhpCollection\CollectionInterface;

class ParagraphFactory implements Context
{
    /** @var ParagraphId */
    private $correctParams = [];
    /** @var ParagraphFactoryInterface */
    private $paragraphFactory;
    /** @var BaseParagraphInterface */
    private $createdParagraph;
    /** @var DeviceQueryRepositoryInterface */
    private $deviceQueryRepository;
    /** @var ParagraphFilterQueryRepositoryInterface */
    private $paragraphFilterQueryRepository;
    /** @var HeaderQueryRepositoryInterface */
    private $headerQueryRepository;

    /**
     * ParagraphFactory constructor.
     * @param ParagraphFactoryInterface $paragraphFactory
     * @param DeviceQueryRepositoryInterface $deviceQueryRepository
     * @param ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository
     * @param HeaderQueryRepositoryInterface $headerQueryRepository
     */
    public function __construct(
        ParagraphFactoryInterface $paragraphFactory,
        DeviceQueryRepositoryInterface $deviceQueryRepository,
        ParagraphFilterQueryRepositoryInterface $paragraphFilterQueryRepository,
        HeaderQueryRepositoryInterface $headerQueryRepository
    ) {
        $this->paragraphFactory = $paragraphFactory;
        $this->deviceQueryRepository = $deviceQueryRepository;
        $this->paragraphFilterQueryRepository = $paragraphFilterQueryRepository;
        $this->headerQueryRepository = $headerQueryRepository;
    }

    /**
     * @Given I'm Set Correct Params For Root Paragraph Without Device
     */
    public function imSetCorrectParamsForRootParagraphWithoutDevice()
    {
        $this->correctParams['paragraphId'] = new ParagraphId("63bea125-46f1-4d59-b6ec-13000d13ac9f");
        $this->correctParams['sectionId'] = new SectionId("63bea125-46f1-4d59-b6ec-65000d13ac2f");
        $this->correctParams['header'] =
            $this->headerQueryRepository->findByParagraphId(new ParagraphId("63bea125-46f1-4d59-b6ec-13000d13ac9f"));
    }

    /**
     * @When I Call Method makeRootWithoutDevice
     */
    public function iCallMethodMakerootwithoutdevice()
    {
        /** @var RootParagraphWithoutDeviceInterface createdParagraph */
        $this->createdParagraph = $this->paragraphFactory->makeRootWithoutDevice(
            $this->correctParams['paragraphId'],
            $this->correctParams['sectionId'],
            $this->correctParams['header']
        );
    }

    /**
     * @Then I Should Get Correct Root Paragraph Without Device
     *
     * @throws Exception
     */
    public function iShouldGetCorrectRootParagraphWithoutDevice()
    {
        if (!$this->createdParagraph instanceof RootParagraphWithoutDeviceInterface) {
            throw new Exception("Paragraph is not implemented RootParagraphWithoutDeviceInterface");
        }

        $this->checkBaseField();
    }

    /**
     * @Given I'm Set Correct Params For Root Paragraph With Device
     */
    public function imSetCorrectParamsForRootParagraphWithDevice()
    {
        $this->correctParams['paragraphId'] = new ParagraphId("63bea125-46f1-4d59-b6ec-13000d13ac9f");
        $this->correctParams['sectionId'] = new SectionId("63bea125-46f1-4d59-b6ec-65000d13ac2f");
        $this->correctParams['deviceId'] = new DeviceId("63bea125-46f1-4d59-b6ec-65000d13ac1f");
        $this->correctParams['paragraphFilterId'] = new ParagraphFilterId("inspection");
        $this->correctParams['header'] =
            $this->headerQueryRepository->findByParagraphId(new ParagraphId("63bea125-46f1-4d59-b6ec-13000d13ac9f"));
    }

    /**
     * @When I Call Method makeRootWithDevice
     */
    public function iCallMethodMakerootwithdevice()
    {
        /** @var Device $device */
        $device = $this->deviceQueryRepository->find($this->correctParams['deviceId']);
        /** @var ParagraphFilterInterface $filter */
        $filter = $this->paragraphFilterQueryRepository->find($this->correctParams['paragraphFilterId']);

        /** @var RootParagraphWithDeviceInterface createdParagraph */
        $this->createdParagraph = $this->paragraphFactory->makeRootWithDevice(
            $this->correctParams['paragraphId'],
            $this->correctParams['sectionId'],
            $device,
            $filter,
            $this->correctParams['header']
        );
    }

    /**
     * @Then I Should Get Correct Root Paragraph With Device
     *
     * @throws Exception
     */
    public function iShouldGetCorrectRootParagraphWithDevice()
    {
        if (!$this->createdParagraph instanceof RootParagraphWithDeviceInterface) {
            throw new Exception("Paragraph is not implemented RootParagraphWithDeviceInterface");
        }

        if (!in_array(
            $this->createdParagraph->getFilter()->getId()->getValue(),
            RootParagraphWithDeviceInterface::AVAILABLE_FILTERS
        )) {
            throw new Exception("Paragraph has not available Filter");
        }

        $this->checkBaseField();
    }

    /**
     * @throws Exception
     */
    private function checkBaseField()
    {
        if (!$this->createdParagraph->getItems() instanceof CollectionInterface) {
            throw new Exception("Paragraph field Items not implemented CollectionInterface");
        }

        if (is_bool($this->createdParagraph->isPrintable()) === false) {
            throw new Exception("Paragraph field isPrintable not Boolean");
        }
    }
}
