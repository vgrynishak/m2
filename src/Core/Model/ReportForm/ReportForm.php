<?php

namespace App\Core\Model\ReportForm;

use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\ReportForm\ReportFormStatus\ReportFormStatusInterface;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class ReportForm implements ReportFormInterface
{
    /** @var ReportFormId */
    private $id;
    /** @var ReportTemplateId */
    private $reportTemplateId;
    /** @var FacilityId */
    private $facilityId;
    /** @var ServiceInstanceId */
    private $serviceInstanceId;
    /** @var DeviceInstanceId */
    private $deviceInstanceId;
    /** @var ReportFormStatusInterface */
    private $status;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $modifiedAt;
    /** @var UserInterface */
    private $createdBy;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var CollectionInterface */
    private $screens;

    /**
     * ReportForm constructor.
     * @param ReportFormId $id
     * @param ReportTemplateId $reportTemplateId
     * @param FacilityId $facilityId
     * @param ServiceInstanceId $serviceInstanceId
     * @param DeviceInstanceId $deviceInstanceId
     */
    public function __construct(
        ReportFormId $id,
        ReportTemplateId $reportTemplateId,
        FacilityId $facilityId,
        ServiceInstanceId $serviceInstanceId,
        DeviceInstanceId $deviceInstanceId
    ) {
        $this->id = $id;
        $this->reportTemplateId = $reportTemplateId;
        $this->facilityId = $facilityId;
        $this->serviceInstanceId = $serviceInstanceId;
        $this->deviceInstanceId = $deviceInstanceId;
    }

    public function getId(): ReportFormId
    {
        return $this->id;
    }

    public function getReportTemplateId(): ReportTemplateId
    {
        return $this->reportTemplateId;
    }

    public function getFacilityId(): FacilityId
    {
        return $this->facilityId;
    }

    public function getServiceInstanceId(): ServiceInstanceId
    {
        return $this->serviceInstanceId;
    }

    public function getDeviceInstanceId(): DeviceInstanceId
    {
        return $this->deviceInstanceId;
    }

    public function getStatus(): ReportFormStatusInterface
    {
        return $this->status;
    }

    public function setStatus(ReportFormStatusInterface $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getModifiedAt(): DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    public function setScreens(?CollectionInterface $screens): void
    {
        $this->screens = $screens;
    }

    public function getScreens(): ?CollectionInterface
    {
        return $this->screens;
    }
}
