<?php

namespace App\App\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ParagraphRepository")
 * @ORM\Table(name="paragraph",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class Paragraph
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Section")
     *
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id", nullable=false)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":1})
     */
    private $level = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Paragraph")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Device")
     */
    private $device;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\StyleTemplate")
     */
    private $styleTemplate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $printable;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ParagraphFilter")
     */
    private $paragraphFilter;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $modifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\HeaderType")
     */
    private $headerType;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Section
     */
    public function getSection(): Section
    {
        return $this->section;
    }

    /**
     * @param Section $section
     * @return $this
     */
    public function setSection(Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
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
     * @return $this
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
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
     * @return $this
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Paragraph|null
     */
    public function getParent(): ?Paragraph
    {
        return $this->parent;
    }

    /**
     * @param Paragraph|null $parent
     * @return $this
     */
    public function setParent(?Paragraph $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Device|null
     */
    public function getDevice(): ?Device
    {
        return $this->device;
    }

    /**
     * @param Device|null $device
     * @return $this
     */
    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return StyleTemplate|null
     */
    public function getStyleTemplate(): ?StyleTemplate
    {
        return $this->styleTemplate;
    }

    /**
     * @param StyleTemplate|null $styleTemplate
     * @return $this
     */
    public function setStyleTemplate(?StyleTemplate $styleTemplate): self
    {
        $this->styleTemplate = $styleTemplate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPrintable(): ?bool
    {
        return $this->printable;
    }

    /**
     * @param bool $printable
     * @return $this
     */
    public function setPrintable(bool $printable): self
    {
        $this->printable = $printable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ParagraphFilter|null
     */
    public function getParagraphFilter(): ?ParagraphFilter
    {
        return $this->paragraphFilter;
    }

    /**
     * @param ParagraphFilter|null $paragraphFilter
     * @return $this
     */
    public function setParagraphFilter(?ParagraphFilter $paragraphFilter): self
    {
        $this->paragraphFilter = $paragraphFilter;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param User|null $createdBy
     * @return $this
     */
    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    /**
     * @param User|null $modifiedBy
     * @return $this
     */
    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * @return HeaderType
     */
    public function getHeaderType(): HeaderType
    {
        return $this->headerType;
    }

    /**
     * @param HeaderType $headerType
     * @return $this
     */
    public function setHeaderType(HeaderType $headerType): self
    {
        $this->headerType = $headerType;

        return $this;
    }
}
