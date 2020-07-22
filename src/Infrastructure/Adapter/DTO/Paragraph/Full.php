<?php

namespace App\Infrastructure\Adapter\DTO\Paragraph;

class Full
{
    /** @var string */
    private $id;
    /** @var string | null */
    private $sectionId;
    /** @var string | null */
    private $headerValue;
    /** @var int | null */
    private $position;
    /** @var bool */
    private $printable = true;
    /** @var int */
    private $updatedAt;
    /** @var int */
    private $createdAt;
    /** @var array | null */
    private $items;
    /** @var string | null */
    private $styleTemplateId;
    /** @var string | null */
    private $createdById;
    /** @var string | null */
    private $modifiedById;
    /** @var string | null */
    private $paragraphFilterId;
    /** @var string | null */
    private $deviceId;
    /** @var string | null */
    private $parentId;
    /** @var int | null */
    private $level;

    /**
     * Full constructor.
     * @param string $id
     * @param int $updatedAt
     * @param int $createdAt
     */
    public function __construct(string $id, int $updatedAt, int $createdAt)
    {
        $this->id = $id;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @param string|null $sectionId
     */
    public function setSectionId(?string $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @param string|null $headerValue
     */
    public function setHeaderValue(?string $headerValue): void
    {
        $this->headerValue = $headerValue;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param bool $printable
     */
    public function setPrintable(bool $printable): void
    {
        $this->printable = $printable;
    }

    /**
     * @param array|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param string|null $styleTemplateId
     */
    public function setStyleTemplateId(?string $styleTemplateId)
    {
        $this->styleTemplateId = $styleTemplateId;
    }

    /**
     * @param string|null $modifiedById
     */
    public function setModifiedById(?string $modifiedById): void
    {
        $this->modifiedById = $modifiedById;
    }

    /**
     * @param string|null $createdById
     */
    public function setCreatedById(?string $createdById): void
    {
        $this->createdById = $createdById;
    }

    /**
     * @param string|null $filterId
     */
    public function setParagraphFilterId(?string $filterId): void
    {
        $this->paragraphFilterId = $filterId;
    }

    /**
     * @param string|null $deviceId
     */
    public function setDeviceId(?string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @param string|null $parentId
     */
    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @param int|null $level
     */
    public function setLevel(?int $level): void
    {
        $this->level = $level;
    }
}
