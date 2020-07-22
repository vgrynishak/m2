<?php

namespace App\App\Doctrine\Entity;

use App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\SectionRepository")
 * @ORM\Table(name="section",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class Section
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersion")
     */
    private $reportTemplateVersion;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $printable;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPrintable(): ?bool
    {
        return $this->printable;
    }

    public function setPrintable(bool $printable): self
    {
        $this->printable = $printable;

        return $this;
    }

    public function getReportTemplateVersion(): ?ReportTemplateVersion
    {
        return $this->reportTemplateVersion;
    }

    public function setReportTemplateVersion(?ReportTemplateVersion $reportTemplateVersion): self
    {
        $this->reportTemplateVersion = $reportTemplateVersion;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

}
