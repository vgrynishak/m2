<?php

namespace App\Core\Model\ReportTemplate;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class ReportTemplate implements ReportTemplateInterface
{
    /** @var ReportTemplateId  */
    private $id;
    /** @var string */
    private $name;
    /** @var string|null  */
    private $description = null;
    /** @var ServiceId  */
    private $serviceId;
    /** @var DeviceId */
    private $deviceId;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var int */
    private $versionNumber = 1;
    /** @var UserInterface */
    private $createdBy;
    /** @var UserInterface */
    private $modifiedBy;
    /** @var ReportTemplateStatusInterface */
    private $status;
    /** @var CollectionInterface|null */
    private $sections;
    /** @var DeviceInterface|null */
    private $device;
    /** @var ServiceInterface|null */
    private $service;

    /**
     * ReportTemplate constructor.
     * @param ReportTemplateId $id
     * @param string $name
     * @param ServiceId $serviceId
     * @param DeviceId $deviceId
     */
    public function __construct(
        ReportTemplateId $id,
        string $name,
        ServiceId $serviceId,
        DeviceId $deviceId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->serviceId = $serviceId;
        $this->deviceId = $deviceId;
    }

    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return ServiceId
     */
    public function getServiceId(): ServiceId
    {
        return $this->serviceId;
    }

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId
    {
        return $this->deviceId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getVersionNumber(): int
    {
        return $this->versionNumber;
    }

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @return UserInterface
     */
    public function getModifiedBy(): UserInterface
    {
        return $this->modifiedBy;
    }

    /**
     * @return ReportTemplateStatusInterface
     */
    public function getStatus(): ReportTemplateStatusInterface
    {
        return $this->status;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getSections(): ?CollectionInterface
    {
        return $this->sections;
    }

    /**
     * @param ReportTemplateId $id
     */
    public function setId(ReportTemplateId $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param int $versionNumber
     */
    public function setVersionNumber(int $versionNumber): void
    {
        $this->versionNumber = $versionNumber;
    }

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param UserInterface $modifiedBy
     */
    public function setModifiedBy(UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @param ReportTemplateStatusInterface $status
     */
    public function setStatus(ReportTemplateStatusInterface $status): void
    {
        $this->status = $status;
    }

    /**
     * @param CollectionInterface $sections
     */
    public function setSections(?CollectionInterface $sections): void
    {
        $this->sections = $sections;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return DeviceInterface|null
     */
    public function getDevice(): ?DeviceInterface
    {
        return $this->device;
    }

    /**
     * @param DeviceInterface|null $device
     */
    public function setDevice(?DeviceInterface $device): void
    {
        $this->device = $device;
    }

    /**
     * @return ServiceInterface|null
     */
    public function getService(): ?ServiceInterface
    {
        return $this->service;
    }

    /**
     * @param ServiceInterface|null $service
     */
    public function setService(?ServiceInterface $service): void
    {
        $this->service = $service;
    }
}
