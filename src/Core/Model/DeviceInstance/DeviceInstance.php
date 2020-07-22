<?php

namespace App\Core\Model\DeviceInstance;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;
use DateTime;

class DeviceInstance implements DeviceInstanceInterface
{
    /** @var DeviceInstanceId */
    private $id;
    /** @var DeviceInterface */
    private $device;
    /** @var FacilityId */
    private $facilityId;
    /** @var DeviceInstanceId | null */
    private $parentId;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface | null */
    private $createdBy;
    /** @var DateTime | null */
    private $modifiedAt;
    /** @var DateTime | null */
    private $createdAt;

    /**
     * DeviceInstance constructor.
     * @param DeviceInstanceId $id
     * @param DeviceInterface $device
     * @param FacilityId $facilityId
     */
    public function __construct(DeviceInstanceId $id, DeviceInterface $device, FacilityId $facilityId)
    {
        $this->id = $id;
        $this->device = $device;
        $this->facilityId = $facilityId;
    }

    /**
     * @return DeviceInstanceId
     */
    public function getId(): DeviceInstanceId
    {
        return $this->id;
    }

    /**
     * @return DeviceInterface
     */
    public function getDevice(): DeviceInterface
    {
        return $this->device;
    }

    /**
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId
    {
        return $this->facilityId;
    }

    /**
     * @param DeviceInstanceId|null $parentId
     */
    public function setParentId(?DeviceInstanceId $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return DeviceInstanceId|null
     */
    public function getParentId(): ?DeviceInstanceId
    {
        return $this->parentId;
    }

    /**
     * @return UserInterface|null
     */
    public function getModifiedBy(): ?UserInterface
    {
        return $this->modifiedBy;
    }

    /**
     * @param UserInterface|null $modifiedBy
     */
    public function setModifiedBy(?UserInterface $modifiedBy): void
    {
        $this->modifiedBy = $modifiedBy;
    }

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface|null $createdBy
     */
    public function setCreatedBy(?UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return DateTime|null
     */
    public function getModifiedAt(): ?DateTime
    {
        return $this->modifiedAt;
    }

    /**
     * @param DateTime|null $modifiedAt
     */
    public function setModifiedAt(?DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
