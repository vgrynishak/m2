<?php

namespace App\Core\Model\ReportForm\Screen;

use App\Core\Model\ReportForm\ReportFormId;
use App\Core\Model\Section\SectionId;
use DateTime;
use PhpCollection\CollectionInterface;

class Screen implements ScreenInterface
{
    /** @var ScreenId */
    private $id;
    /** @var SectionId */
    private $sectionId;
    /** @var ReportFormId */
    private $reportFormId;
    /** @var DateTime */
    private $createAt;
    /** @var DateTime */
    private $modifiedAt;
    /** @var CollectionInterface */
    private $containers;

    /**
     * Screen constructor.
     * @param ScreenId $id
     * @param SectionId $sectionId
     * @param ReportFormId $reportFormId
     */
    public function __construct(
        ScreenId $id,
        SectionId $sectionId,
        ReportFormId $reportFormId
    ) {
        $this->id = $id;
        $this->sectionId = $sectionId;
        $this->reportFormId = $reportFormId;
    }

    public function getId(): ScreenId
    {
        return $this->id;
    }

    public function getSectionId(): SectionId
    {
        return $this->sectionId;
    }

    public function getReportFormId(): ReportFormId
    {
        return $this->reportFormId;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createAt = $createdAt;
    }

    public function getModifiedAt(): DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    public function setContainers(?CollectionInterface $containers): void
    {
        $this->containers = $containers;
    }

    public function getContainers(): ?CollectionInterface
    {
        return $this->containers;
    }
}
