<?php

namespace App\Core\Model\Section;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class Section implements SectionInterface
{
    /** @var SectionId */
    private $id;
    /** @var ReportTemplateId */
    private $reportTemplateId;
    /** @var string */
    private $title;
    /** @var int|null */
    private $position;
    /** @var DateTime|null */
    private $createdAt;
    /** @var DateTime|null */
    private $modifiedAt;
    /** @var UserInterface|null */
    private $createdBy;
    /** @var UserInterface|null */
    private $modifiedBy;
    /** @var bool|null */
    private $printable;
    /** @var CollectionInterface|null */
    private $paragraphs;

    /**
     * Section constructor.
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
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getModifiedAt(): ?DateTime
    {
        return $this->modifiedAt;
    }

    /**
     * @param DateTime|null $modifiedAt
     */
    public function setModifiedAt(?DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface|null $createdBy
     */
    public function setCreatedBy(?UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return UserInterface|null
     */
    public function getModifiedBy(): ?UserInterface
    {
        return $this->modifiedBy;
    }

    /**
     * @param UserInterface|null $modifiedBy
     */
    public function setModifiedBy(?UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return bool|null
     */
    public function isPrintable(): ?bool
    {
        return $this->printable;
    }

    /**
     * @param bool|null $printable
     */
    public function setPrintable(?bool $printable): void
    {
        $this->printable = $printable;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getParagraphs(): ?CollectionInterface
    {
        return $this->paragraphs;
    }

    /**
     * @param CollectionInterface|null $paragraphs
     */
    public function setParagraphs(?CollectionInterface $paragraphs): void
    {
        $this->paragraphs = $paragraphs;
    }
}
