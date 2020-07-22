<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\User;
use App\Core\Model\User\UserInterface;
use DateTime;

class CreateRootWithoutDeviceCommand implements CreateRootWithoutDeviceCommandInterface
{
    /** @var ParagraphId  */
    private $id;
    /** @var SectionId  */
    private $sectionId;
    /** @var bool */
    private $printable;
    /** @var UserInterface */
    private $createdBy;
    /** @var DateTime */
    private $createdAt;
    /** @var StyleTemplateId */
    private $styleTemplateId;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * CreateRootWithoutDeviceCommand constructor.
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param bool $printable
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        SectionId $sectionId,
        bool $printable,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
        $this->sectionId = $sectionId;
        $this->printable = $printable;
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
    public function isPrintable(): ?bool
    {
        return $this->printable;
    }

    /**
     * @param bool $printable
     */
    public function setPrintable(?bool $printable): void
    {
        $this->printable = $printable;
    }

    /**
     * @return User
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
     * @return StyleTemplateId|null
     */
    public function getStyleTemplateId(): ?StyleTemplateId
    {
        return $this->styleTemplateId;
    }

    /**
     * @param StyleTemplateId $styleTemplateId
     */
    public function setStyleTemplateId(StyleTemplateId $styleTemplateId): void
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
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface
    {
        return $this->header;
    }
}
