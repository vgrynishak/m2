<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class RootParagraphWithDevice implements RootParagraphWithDeviceInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var SectionId  */
    private $section;
    /** @var int  */
    private $position;
    /** @var DeviceInterface  */
    private $device;
    /** @var StyleTemplateId */
    private $styleTemplate;
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
    /** @var CollectionInterface | null */
    private $children;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * RootParagraphWithDevice constructor.
     * @param ParagraphId $id
     * @param SectionId $section
     * @param DeviceInterface $device
     * @param ParagraphFilterInterface $filter
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        SectionId $section,
        DeviceInterface $device,
        ParagraphFilterInterface $filter,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
        $this->section = $section;
        $this->device = $device;
        $this->filter = $filter;
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
     * @return SectionId
     */
    public function getSectionId(): SectionId
    {
        return $this->section;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @return DeviceInterface
     */
    public function getDevice(): DeviceInterface
    {
        return $this->device;
    }

    /**
     * @return StyleTemplateId
     */
    public function getStyleTemplateId(): ?StyleTemplateId
    {
        return $this->styleTemplate;
    }

    /**
     * @return bool
     */
    public function isPrintable(): bool
    {
        return $this->printable;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return ParagraphFilterInterface
     */
    public function getFilter(): ParagraphFilterInterface
    {
        return $this->filter;
    }

    /**
     * @return CollectionInterface
     */
    public function getItems(): CollectionInterface
    {
        return $this->items;
    }

    /**
     * @param StyleTemplateId|null $styleTemplateId
     */
    public function setStyleTemplateId(?StyleTemplateId $styleTemplateId)
    {
        $this->styleTemplate = $styleTemplateId;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param CollectionInterface $items
     */
    public function setItems(?CollectionInterface $items): void
    {
        $this->items = $items;
    }

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param UserInterface $modifiedBy
     */
    public function setModifiedBy(UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @param int $position
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
     * @return SectionId
     */
    public function getSection(): SectionId
    {
        return $this->section;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
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
