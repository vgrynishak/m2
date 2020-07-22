<?php
namespace App\Core\Service\Paragraph;

use App\Core\Model\Paragraph\WithDeviceParagraphInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Section\SectionId;

interface FilterDeterminerInterface
{
    /**
     * @param DeviceId $paragraphDeviceId
     * @param SectionId $sectionId
     *
     * @return ParagraphFilterInterface
     */
    public function determineForRoot(DeviceId $paragraphDeviceId, SectionId $sectionId) : ParagraphFilterInterface;

    /**
     * @param DeviceId $paragraphDeviceId
     * @param DeviceId $parentDeviceId
     *
     * @return ParagraphFilterInterface
     */
    public function determineForChild(DeviceId $paragraphDeviceId, DeviceId $parentDeviceId) : ParagraphFilterInterface;
}
