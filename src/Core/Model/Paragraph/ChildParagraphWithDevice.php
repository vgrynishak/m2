<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class ChildParagraphWithDevice implements ChildParagraphWithDeviceInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var ParagraphId */
    private $parent;
    /** @var SectionId  */
    private $sectionId;
    /** @var int  */
    private $position;
    /** @var DeviceInterface  */
    private $device;
    /** @var StyleTemplateId */
    private $styleTemplateId;
    /** @var bool  */
    private $printable = true;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var UserInterface */
    private $createdBy;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var ParagraphFilterInterface */
    private $filter;
    /** @var CollectionInterface */
    private $items;
    /** @var int */
    private $level;
    /** @var CollectionInterface | null */
    private $children;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * ChildParagraphWithDevice constructor.
     * @param ParagraphId $id
     * @param ParagraphId $parentId
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param SectionId $sectionId
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        ParagraphId $parentId,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        SectionId $sectionId,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
        $this->parent = $parentId;
        $this->device = $device;
        $this->filter = $filter;
        $this->sectionId = $sectionId;
        $this->header = $header;
    }

    /**
     * @return ParagraphId
     */
    public function getId(): ParagraphId
    {
        return $this->id;
    }

    /**
     * @return ParagraphId
     */
    public function getParent(): ParagraphId
    {
        return $this->parent;
    }

    /**
     * @return DeviceInterface
     */
    public function getDevice(): DeviceInterface
    {
        return $this->device;
    }

    /**
     * @return ParagraphFilterInterface
     */
    public function getFilter(): ParagraphFilterInterface
    {
        return $this->filter;
    }

    /**
     * @return SectionId
     */
    public function getSectionId(): SectionId
    {
        return $this->sectionId;
    }

    /**
     * @param SectionId $sectionId
     */
    public function setSectionId(SectionId $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return StyleTemplateId
     */
    public function getStyleTemplateId(): ?StyleTemplateId
    {
        return $this->styleTemplateId;
    }

    /**
     * @param StyleTemplateId $styleTemplateId
     */
    public function setStyleTemplateId(?StyleTemplateId $styleTemplateId): void
    {
        $this->styleTemplateId = $styleTemplateId;
    }

    /**
     * @return bool
     */
    public function isPrintable(): bool
    {
        return $this->printable;
    }

    /**
     * @param bool $printable
     */
    public function setPrintable(bool $printable): void
    {
        $this->printable = $printable;
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
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }

    /**
     * @param UserInterface $modifiedBy
     */
    public function setModifiedBy(UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return CollectionInterface
     */
    public function getItems(): CollectionInterface
    {
        return $this->items;
    }

    /**
     * @param CollectionInterface $items
     */
    public function setItems(?CollectionInterface $items): void
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getChildren(): ?CollectionInterface
    {
        return $this->children;
    }

    /**
     * @param CollectionInterface|null $paragraphs
     */
    public function setChildren(?CollectionInterface $paragraphs): void
    {
        $this->children = $paragraphs;
    }

    /**
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface
    {
        return $this->header;
    }

    /**
     * @param BaseHeaderInterface $header
     */
    public function setHeader(BaseHeaderInterface $header): void
    {
        $this->header = $header;
    }
}
