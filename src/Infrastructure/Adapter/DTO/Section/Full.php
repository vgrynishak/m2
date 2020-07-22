<?php

namespace App\Infrastructure\Adapter\DTO\Section;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $reportTemplateId;
    /** @var string */
    private $title;
    /** @var int|null */
    private $position;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $modifiedAt;
    /** @var int */
    private $createdById;
    /** @var int */
    private $modifiedById;
    /** @var bool */
    private $printable;
    /** @var array|null */
    private $paragraphs;

    /**
     * Full constructor.
     * @param string $id
     * @param string $reportTemplateId
     * @param string $title
     */
    public function __construct(string $id, string $reportTemplateId, string $title)
    {
        $this->id = $id;
        $this->reportTemplateId = $reportTemplateId;
        $this->title = $title;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param int|null $createdAt
     */
    public function setCreatedAt(?int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param int|null $modifiedAt
     */
    public function setModifiedAt(?int $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @param string|null $createdById
     */
    public function setCreatedById(?string $createdById): void
    {
        $this->createdById = $createdById;
    }

    /**
     * @param string|null $modifiedById
     */
    public function setModifiedById(?string $modifiedById): void
    {
        $this->modifiedById = $modifiedById;
    }

    /**
     * @param bool $printable
     */
    public function setPrintable(bool $printable): void
    {
        $this->printable = $printable;
    }

    /**
     * @param array $paragraphs
     */
    public function setParagraphs(array $paragraphs): void
    {
        $this->paragraphs = $paragraphs;
    }
}
