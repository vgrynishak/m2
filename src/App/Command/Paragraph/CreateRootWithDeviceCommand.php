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

class CreateRootWithDeviceCommand implements CreateRootWithDeviceCommandInterface
{
    /** @var ParagraphId */
    private $id;
    /** @var SectionId */
    private $sectionId;
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
    /** @var BaseHeaderInterface */
    private $header;

    /**
     * CreateRootWithDeviceCommand constructor.
     * @param ParagraphId $id
     * @param SectionId $sectionId
     * @param DeviceId $deviceId
     * @param ParagraphFilterId $paragraphFilterId
     * @param BaseHeaderInterface $header
     */
    public function __construct(
        ParagraphId $id,
        SectionId $sectionId,
        DeviceId $deviceId,
        ParagraphFilterId $paragraphFilterId,
        BaseHeaderInterface $header
    ) {
        $this->id = $id;
        $this->sectionId = $sectionId;
        $this->deviceId = $deviceId;
        $this->paragraphFilterId = $paragraphFilterId;
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
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
     * @return BaseHeaderInterface
     */
    public function getHeader(): BaseHeaderInterface
    {
        return $this->header;
    }
}
