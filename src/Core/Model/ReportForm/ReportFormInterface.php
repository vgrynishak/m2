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

interface ReportFormInterface
{
    public function getId(): ReportFormId;

    public function getReportTemplateId(): ReportTemplateId;

    public function getFacilityId(): FacilityId;

    public function getServiceInstanceId(): ServiceInstanceId;

    public function getDeviceInstanceId(): DeviceInstanceId;

    public function getStatus(): ReportFormStatusInterface;

    public function setStatus(ReportFormStatusInterface $status): void;

    public function setScreens(?CollectionInterface $screens): void;

    public function getScreens(): ?CollectionInterface;

    public function getCreatedAt(): DateTime;

    public function setCreatedAt(DateTime $createdAt): void;

    public function getCreatedBy(): UserInterface;

    public function setCreatedBy(UserInterface $createdBy): void;

    public function getModifiedAt(): DateTime;

    public function setModifiedAt(DateTime $modifiedAt): void;

    public function getModifiedBy(): UserInterface;

    public function setModifiedBy(UserInterface $modifiedBy): void;
}
