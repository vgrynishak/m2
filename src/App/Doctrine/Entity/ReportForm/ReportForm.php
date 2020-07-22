<?php

namespace App\App\Doctrine\Entity\ReportForm;

use App\App\Doctrine\Entity\DeviceInstance;
use App\App\Doctrine\Entity\Facility;
use App\App\Doctrine\Entity\ReportTemplate\ReportTemplate;
use App\App\Doctrine\Entity\ServiceInstance;
use App\App\Doctrine\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\App\Doctrine\Repository\ReportForm\ReportFormRepository")
 * @ORM\Table(name="report_form")
 */
class ReportForm
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportTemplate\ReportTemplate")
     * @ORM\JoinColumn(name="report_tempalate_id", nullable=false)
     */
    private $reportTemplate;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\Facility")
     * @ORM\JoinColumn(name="facility_id", nullable=false)
     */
    private $facility;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ServiceInstance")
     * @ORM\JoinColumn(name="service_instance_id", nullable=false)
     */
    private $serviceInstance;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\DeviceInstance")
     * @ORM\JoinColumn(name="device_instance_id", nullable=false)
     */
    private $deviceInstance;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\ReportForm\ReportFormStatus")
     * @ORM\JoinColumn(name="report_form_status_id", nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\App\Doctrine\Entity\ReportForm\Screen", mappedBy="reportForm", cascade={"remove"})
     */
    private $screens;

    /**
     * @ORM\Column(name="created_at", type="timestamp", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="modified_at", type="timestamp", nullable=false)
     */
    private $modifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     * @ORM\JoinColumn(name="created_by", nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\App\Doctrine\Entity\User")
     * @ORM\JoinColumn(name="modified_by", nullable=false)
     */
    private $modifiedBy;

    public function __construct()
    {
        $this->screens = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string  $id
     * @return ReportForm
     */
    public function setId(string $id): ReportForm
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ReportTemplate
     */
    public function getReportTemplate(): ReportTemplate
    {
        return $this->reportTemplate;
    }

    /**
     * @param ReportTemplate $reportTemplate
     * @return ReportForm
     */
    public function setReportTemplate(ReportTemplate $reportTemplate): ReportForm
    {
        $this->reportTemplate = $reportTemplate;
        return $this;
    }

    /**
     * @return Facility
     */
    public function getFacility(): Facility
    {
        return $this->facility;
    }

    /**
     * @param Facility $facility
     * @return ReportForm
     */
    public function setFacility(Facility $facility): ReportForm
    {
        $this->facility = $facility;
        return $this;
    }

    /**
     * @return ServiceInstance
     */
    public function getServiceInstance(): ServiceInstance
    {
        return $this->serviceInstance;
    }

    /**
     * @param ServiceInstance $serviceInstance
     * @return ReportForm
     */
    public function setServiceInstance(ServiceInstance $serviceInstance): ReportForm
    {
        $this->serviceInstance = $serviceInstance;
        return $this;
    }

    /**
     * @return DeviceInstance
     */
    public function getDeviceInstance(): DeviceInstance
    {
        return $this->deviceInstance;
    }

    /**
     * @param DeviceInstance $deviceInstance
     * @return ReportForm
     */
    public function setDeviceInstance(DeviceInstance $deviceInstance): ReportForm
    {
        $this->deviceInstance = $deviceInstance;
        return $this;
    }

    /**
     * @return ReportFormStatus
     */
    public function getStatus(): ReportFormStatus
    {
        return $this->status;
    }

    /**
     * @param ReportFormStatus $status
     * @return ReportForm
     */
    public function setStatus(ReportFormStatus $status): ReportForm
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return ReportForm
     */
    public function setCreatedAt($createdAt): ReportForm
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
     * @return ReportForm
     */
    public function setModifiedAt($modifiedAt): ReportForm
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return ReportForm
     */
    public function setCreatedBy(User $createdBy): ReportForm
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return User
     */
    public function getModifiedBy(): User
    {
        return $this->modifiedBy;
    }

    /**
     * @param User $modifiedBy
     * @return ReportForm
     */
    public function setModifiedBy(User $modifiedBy): ReportForm
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getScreens(): ArrayCollection
    {
        return $this->screens;
    }
}
