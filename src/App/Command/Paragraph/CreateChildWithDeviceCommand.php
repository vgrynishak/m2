<?php

namespace App\App\Command\Paragraph;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Paragraph\Header\BaseHeaderInterface;
use App\Core\Model\Paragraph\ParagraphFilterId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\Paragraph\StyleTemplateId;
use App\Core\Model\Section\SectionId;
use App\Core\Model\User\UserInterface;
use DateTime;

class CreateChildWithDeviceCommand implements CreateChildWithDeviceCommandInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var ParagraphId */
    private $parentId;
    /** @var DeviceId */
    private $deviceId;
    /** @var ParagraphFilterId */
    private $paragraphFilterId;
    /** @var StyleTemplateId */
    private $styleTemplateId;
    /** @var DateTime */
    private $createdAt;
    /** @var UserInterface */
    private $createdBy;
    /** @var bool */
    private $printable;
    /** @var SectionId  */
    private $sectionId;
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * CreateChildWithDeviceCommand constructor.
     * @param ParagraphId $id
     * @param ParagraphId $parentId
     * @param DeviceId $deviceId
     * @param ParagraphFilterId $paragraphFilterId
     * @param SectionId $sectionId
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        ParagraphId $parentId,
        DeviceId $deviceId,
        ParagraphFilterId $paragraphFilterId,
        SectionId $sectionId,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->deviceId = $deviceId;
        $this->paragraphFilterId = $paragraphFilterId;
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
    public function getParentId(): ParagraphId
    {
        return $this->parentId;
    }

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId
    {
        return $this->deviceId;
    }

    /**
     * @return ParagraphFilterId
     */
    public function getParagraphFilterId(): ParagraphFilterId
    {
        return $this->paragraphFilterId;
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
     * @return SectionId
     */
    public function getSectionId(): SectionId
    {
        return $this->sectionId;
    }

    /**
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface
    {
        return $this->header;
    }
}
