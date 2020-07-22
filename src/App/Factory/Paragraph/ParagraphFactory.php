<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\BaseParagraphInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDevice;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithDevice;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\RootParagraphWithoutDevice;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Section\SectionId;
use DateTime;
use Exception;
use PhpCollection\Set;

class ParagraphFactory implements ParagraphFactoryInterface
{
    /**
     * @param ParagraphId $id
     * @param ParagraphId $parentId
     * @param SectionId $sectionId
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param BaseHeaderInterface $header
     * @return ChildParagraphWithDeviceInterface
     * @throws Exception
     */
    public function makeChildWithDevice(
        ParagraphId $id,
        ParagraphId $parentId,
        SectionId $sectionId,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        BaseHeaderInterface $header
    ): ChildParagraphWithDeviceInterface {
        $paragraph = new ChildParagraphWithDevice($id, $parentId, $device, $filter, $sectionId, $header);
        /** @var ChildParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->fillBase($paragraph);

        return $paragraph;
    }

    /**
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param BaseHeaderInterface $header
     * @return RootParagraphWithDeviceInterface
     * @throws Exception
     */
    public function makeRootWithDevice(
        ParagraphId $id,
        SectionId $sectionId,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        BaseHeaderInterface $header
    ): RootParagraphWithDeviceInterface {
        $paragraph = new RootParagraphWithDevice($id, $sectionId, $device, $filter, $header);
        /** @var RootParagraphWithDeviceInterface $paragraph */
        $paragraph = $this->fillBase($paragraph);

        return $paragraph;
    }

    /**
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param BaseHeaderInterface $header
     * @return RootParagraphWithoutDeviceInterface
     * @throws Exception
     */
    public function makeRootWithoutDevice(
        ParagraphId $id,
        SectionId $sectionId,
        BaseHeaderInterface $header
    ): RootParagraphWithoutDeviceInterface {
        $paragraph = new RootParagraphWithoutDevice($id, $sectionId, $header);
        /** @var RootParagraphWithoutDeviceInterface $paragraph */
        $paragraph = $this->fillBase($paragraph);

        return $paragraph;
    }

    /**
     * @param BaseParagraphInterface $paragraph
     *
     * @return BaseParagraphInterface
     * @throws Exception
     */
    private function fillBase(BaseParagraphInterface $paragraph): BaseParagraphInterface
    {
        $paragraph->setCreatedAt(new DateTime());
        $paragraph->setUpdatedAt(new DateTime());
        $paragraph->setItems(new Set());

        return $paragraph;
    }
}
