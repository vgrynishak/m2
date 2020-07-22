<?php

namespace App\Core\Model\Paragraph;

use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class RootParagraphWithoutDevice implements RootParagraphWithoutDeviceInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var SectionId */
    private $sectionId;
    /** @var bool */
    private $printable = true;
    /** @var CollectionInterface */
    private $items;
    /** @var int|null */
    private $position;
    /** @var StyleTemplateId|null */
    private $styleTemplateId;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var UserInterface */
    private $createdBy;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var CollectionInterface | null */
    private $children;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * RootParagraphWithoutDevice constructor.
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        SectionId $sectionId,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
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
     * @return SectionId
     */
    public function getSectionId(): SectionId
    {
        return $this->sectionId;
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
     * @return CollectionInterface|null
     */
    public function getItems(): ?CollectionInterface
    {
        return $this->items;
    }

    /**
     * @param CollectionInterface|null $items
     */
    public function setItems(?CollectionInterface $items): void
    {
        $this->items = $items;
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
     * @return StyleTemplateId|null
     */
    public function getStyleTemplateId(): ?StyleTemplateId
    {
        return $this->styleTemplateId;
    }

    /**
     * @param StyleTemplateId|null $styleTemplateId
     */
    public function setStyleTemplateId(?StyleTemplateId $styleTemplateId)
    {
        $this->styleTemplateId = $styleTemplateId;
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
