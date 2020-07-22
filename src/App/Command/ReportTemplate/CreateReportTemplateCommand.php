<?php

namespace App\App\Command\ReportTemplate;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\UserInterface;
use DateTime;

class CreateReportTemplateCommand implements CreateReportTemplateCommandInterface
{
    /** @var ReportTemplateId  */
    private $id;
    /** @var DeviceId  */
    private $deviceId;
    /** @var ServiceId  */
    private $serviceId;
    /** @var string */
    private $name;
    /** @var DateTime */
    private $createdAt;
    /** @var string|null  */
    private $description;
    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateReportTemplateCommand constructor.
     * @param ReportTemplateId $id
     * @param DeviceId $deviceId
     * @param ServiceId $serviceId
     * @param string $name
     */
    public function __construct(
        ReportTemplateId $id,
        DeviceId $deviceId,
        ServiceId $serviceId,
        string $name
    ) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->serviceId = $serviceId;
        $this->name = $name;
    }

    /**
     * @return ReportTemplateId
     */
    public function getId(): ReportTemplateId
    {
        return $this->id;
    }

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId
    {
        return $this->deviceId;
    }

    /**
     * @return ServiceId
     */
    public function getServiceId(): ServiceId
    {
        return $this->serviceId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
