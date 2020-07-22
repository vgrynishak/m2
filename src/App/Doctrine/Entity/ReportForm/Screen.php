<?php

namespace App\App\Doctrine\Entity\ReportForm;

use App\App\Doctrine\Entity\Section;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ReportForm\ScreenRepository")
 * @ORM\Table(name="screen")
 */
class Screen
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Section")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportForm\ReportForm")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportForm;

    /**
     * @ORM\OneToMany(targetEntity="App\App\Doctrine\Entity\ReportForm\Container", mappedBy="screenId")
     */
    private $containers;

    /**
     * @ORM\Column(name="created_at", type="timestamp", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="modified_at", type="timestamp", nullable=false)
     */
    private $modifiedAt;

    /**
     * Screen constructor.
     */
    public function __construct()
    {
        $this->containers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Screen
     */
    public function setId($id): Screen
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
     * @return Screen
     */
    public function setSection(Section $section): Screen
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return ReportForm
     */
    public function getReportForm(): ReportForm
    {
        return $this->reportForm;
    }

    /**
     * @param ReportForm $reportForm
     * @return Screen
     */
    public function setReportForm(ReportForm $reportForm): Screen
    {
        $this->reportForm = $reportForm;
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
     * @param mixed $createdAt
     * @return Screen
     */
    public function setCreatedAt($createdAt): Screen
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param mixed $modifiedAt
     * @return Screen
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContainers(): ArrayCollection
    {
        return $this->containers;
    }
}
