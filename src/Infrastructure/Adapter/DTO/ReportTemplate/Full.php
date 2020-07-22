<?php

namespace App\Infrastructure\Adapter\DTO\ReportTemplate;

use App\Infrastructure\Adapter\DTO\User\Full as UserFullDTO;
use App\Infrastructure\Adapter\DTO\Section\Full as SectionFullDTO;
use App\Infrastructure\Adapter\DTO\Device\Full as DeviceFullDTO;
use App\Infrastructure\Adapter\DTO\Service\Full as ServiceFullDTO;
use App\Infrastructure\Adapter\DTO\ReportTemplateStatus\Full as RTStatusFullDTO;

class Full
{
    /** @var string  */
    private $id;
    /** @var string */
    private $name;
    /** @var DeviceFullDTO */
    private $device;
    /** @var ServiceFullDTO */
    private $service;
    /** @var string|null  */
    private $description = null;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $updatedAt;
    /** @var int */
    private $versionNumber = 1;
    /** @var UserFullDTO|null */
    private $createdBy;
    /** @var UserFullDTO|null */
    private $modifiedBy;
    /** @var RTStatusFullDTO */
    private $status;
    /** @var SectionFullDTO[]|null */
    private $sections;

    /**
     * Full constructor.
     * @param string $id
     * @param string $name
     * @param DeviceFullDTO $device
     * @param ServiceFullDTO $service
     * @param RTStatusFullDTO $status
     */
    public function __construct(
        string $id,
        string $name,
        DeviceFullDTO $device,
        ServiceFullDTO $service,
        RTStatusFullDTO $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->device = $device;
        $this->service = $service;
        $this->status = $status;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param int|null $createdAt
     */
    public function setCreatedAt(?int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param int|null $updatedAt
     */
    public function setUpdatedAt(?int $updatedAt): void
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
     * @param UserFullDTO|null $createdBy
     */
    public function setCreatedBy(?UserFullDTO $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param UserFullDTO|null $modifiedBy
     */
    public function setModifiedBy(?UserFullDTO $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @param array|null $sections
     */
    public function setSections(?array $sections): void
    {
        $this->sections = $sections;
    }
}