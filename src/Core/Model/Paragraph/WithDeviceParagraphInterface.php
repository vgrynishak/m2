<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Device\DeviceInterface;
use PhpCollection\CollectionInterface;

interface WithDeviceParagraphInterface extends BaseParagraphInterface
{
    public function getFilter(): ParagraphFilterInterface;

    public function getDevice(): DeviceInterface;

    public function getChildren(): ?CollectionInterface;

    public function setChildren(?CollectionInterface $paragraphs): void;
}
