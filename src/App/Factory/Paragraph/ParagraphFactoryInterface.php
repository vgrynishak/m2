<?php

namespace App\App\Factory\Paragraph;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\RootParagraphWithoutDeviceInterface;
use App\Core\Model\Paragraph\RootParagraphWithDeviceInterface;
use App\Core\Model\Paragraph\ChildParagraphWithDeviceInterface;
use App\Core\Model\Section\SectionId;

interface ParagraphFactoryInterface
{
    /**
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param BaseHeaderInterface $header
     * @return RootParagraphWithoutDeviceInterface
     */
    public function makeRootWithoutDevice(
        ParagraphId $id,
        SectionId $sectionId,
        BaseHeaderInterface $header
    ) : RootParagraphWithoutDeviceInterface;

    /**
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param BaseHeaderInterface $header
     * @return RootParagraphWithDeviceInterface
     */
    public function makeRootWithDevice(
        ParagraphId $id,
        SectionId $sectionId,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        BaseHeaderInterface $header
    ) : RootParagraphWithDeviceInterface;

    /**
     * @param ParagraphId $id
     * @param ParagraphId $parentId
     * @param SectionId $sectionId
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param BaseHeaderInterface $header
     * @return ChildParagraphWithDeviceInterface
     */
    public function makeChildWithDevice(
        ParagraphId $id,
        ParagraphId $parentId,
        SectionId $sectionId,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        BaseHeaderInterface $header
    ) : ChildParagraphWithDeviceInterface;
}
