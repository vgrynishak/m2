<?php

namespace App\App\Command\DeviceInstance;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;

class CreateDeviceInstanceCommand implements CreateDeviceInstanceCommandInterface
{
    /** @var DeviceInstanceId */
    private $id;
    /** @var DeviceId */
    private $deviceId;
    /** @var FacilityId */
    private $facilityId;
    /** @var DeviceInstanceId | null */
    private $parentId;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateDeviceInstanceCommand constructor.
     * @param DeviceInstanceId $id
     * @param DeviceId $deviceId
     * @param FacilityId $facilityId
     * @param UserInterface $createdBy
     */
    public function __construct(
        DeviceInstanceId $id,
        DeviceId $deviceId,
        FacilityId $facilityId,
        UserInterface $createdBy
    ) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->facilityId = $facilityId;
        $this->createdBy = $createdBy;
    }

    /**
     * @return DeviceInstanceId
     */
    public function getId(): DeviceInstanceId
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
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }
}
