<?php

namespace App\App\Doctrine\Entity\ReportTemplate;

use App\App\Doctrine\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ReportTemplate\ReportTemplateVersionRepository")
 * @ORM\Table(name="report_template_version",uniqueConstraints={@UniqueConstraint(name="uuid_idx", columns={"id"})})
 */
class ReportTemplateVersion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportTemplate\ReportTemplate")
     */
    private $reportTemplate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $versionNumber;

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
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportTemplate\ReportTemplateVersionStatus")
     */
    private $reportTemplateVersionStatus;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReportTemplate()
    {
        return $this->reportTemplate;
    }

    /**
     * @param ReportTemplate $reportTemplate
     * @return $this
     */
    public function setReportTemplate(ReportTemplate $reportTemplate): self
    {
        $this->reportTemplate = $reportTemplate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVersionNumber(): ?int
    {
        return $this->versionNumber;
    }

    /**
     * @param int|null $versionNumber
     * @return $this
     */
    public function setVersionNumber(?int $versionNumber): self
    {
        $this->versionNumber = $versionNumber;

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
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @param User $modifiedBy
     * @return $this
     */
    public function setModifiedBy(User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReportTemplateVersionStatus()
    {
        return $this->reportTemplateVersionStatus;
    }

    /**
     * @param ReportTemplateVersionStatus $reportTemplateVersionStatus
     * @return $this
     */
    public function setReportTemplateVersionStatus(ReportTemplateVersionStatus $reportTemplateVersionStatus): self
    {
        $this->reportTemplateVersionStatus = $reportTemplateVersionStatus;

        return $this;
    }
}
