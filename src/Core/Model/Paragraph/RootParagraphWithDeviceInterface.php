<?php

namespace App\Core\Model\Paragraph;

interface RootParagraphWithDeviceInterface extends RootParagraphInterface, WithDeviceParagraphInterface
{
    const AVAILABLE_FILTERS = [
        ParagraphFilter::FILTER_INSPECTION,
        ParagraphFilter::FILTER_ON_SITE
    ];
}
