<?php

namespace App\Core\Model\ReportTemplate;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\ModelInterface;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

interface ReportTemplateInterface extends ModelInterface
{
    public function getId(): ReportTemplateId;

    public function getName(): string;

    public function getDescription(): ?string;

    public function getServiceId(): ServiceId;

    public function getDeviceId(): DeviceId;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): DateTime;

    public function getVersionNumber(): int;

    public function getCreatedBy(): UserInterface;

    public function getModifiedBy(): UserInterface;

    public function getStatus(): ReportTemplateStatusInterface;

    public function getSections(): ?CollectionInterface;

    public function setDescription(string $description): void;

    public function setCreatedAt(DateTime $createdAt): void;

    public function setUpdatedAt(DateTime $updatedAt): void;

    public function setVersionNumber(int $versionNumber): void;

    public function setCreatedBy(UserInterface $createdBy): void;

    public function setModifiedBy(UserInterface $modifiedBy): void;

    public function setStatus(ReportTemplateStatusInterface $status): void;

    public function setSections(?CollectionInterface $sections): void;

    public function setDevice(?DeviceInterface $device): void;

    public function getDevice(): ?DeviceInterface;

    public function setService(?ServiceInterface $service): void;

    public function getService(): ?ServiceInterface;
}
