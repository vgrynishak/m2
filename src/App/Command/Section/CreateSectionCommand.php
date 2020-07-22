<?php

namespace App\App\Command\Section;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;

class CreateSectionCommand implements CreateSectionCommandInterface
{
    /** @var SectionId */
    private $id;
    /** @var ReportTemplateId */
    private $reportTemplateId;
    /** @var string */
    private $title;
    /** @var DateTime */
    private $createdAt;
    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateSectionCommand constructor.
     * @param SectionId $id
     * @param ReportTemplateId $reportTemplateId
     * @param string $title
     */
    public function __construct(
        SectionId $id,
        ReportTemplateId $reportTemplateId,
        string $title
    ) {
        $this->id = $id;
        $this->reportTemplateId = $reportTemplateId;
        $this->title = $title;
    }

    /**
     * @return SectionId
     */
    public function getId(): SectionId
    {
        return $this->id;
    }

    /**
     * @return ReportTemplateId
     */
    public function getReportTemplateId(): ReportTemplateId
    {
        return $this->reportTemplateId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
}
