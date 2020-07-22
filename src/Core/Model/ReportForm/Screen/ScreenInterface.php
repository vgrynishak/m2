<?php

namespace App\Core\Model\ReportForm\Screen;

use App\Core\Model\ReportForm\ReportFormId;
use App\Core\Model\Section\SectionId;
use DateTime;
use PhpCollection\CollectionInterface;

interface ScreenInterface
{
    public function getId(): ScreenId;

    public function getSectionId(): SectionId;

    public function getReportFormId(): ReportFormId;

    public function getCreatedAt(): DateTime;

    public function setContainers(?CollectionInterface $containers);

    public function getContainers(): ?CollectionInterface;

    public function setCreatedAt(DateTime $createdAt): void;

    public function getModifiedAt(): DateTime;

    public function setModifiedAt(DateTime $modifiedAt): void;
}
