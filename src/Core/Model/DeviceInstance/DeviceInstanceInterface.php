<?php

namespace App\Core\Model\DeviceInstance;

use App\Core\Model\Device\DeviceInterface;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\ModelInterface;
use App\Core\Model\User\UserInterface;
use DateTime;

interface DeviceInstanceInterface extends ModelInterface
{
    /**
     * @return DeviceInstanceId
     */
    public function getId(): DeviceInstanceId;

    /**
     * @return DeviceInterface
     */
    public function getDevice(): DeviceInterface;

    /**
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId;

    /**
     * @return DeviceInstanceId | null
     */
    public function getParentId(): ?DeviceInstanceId;

    /**
     * @param DeviceInstanceId|null $parentId
     */
    public function setParentId(?DeviceInstanceId $parentId): void;

    /**
     * @return UserInterface|null
     */
    public function getModifiedBy(): ?UserInterface;

    /**
     * @param UserInterface|null $modifiedBy
     */
    public function setModifiedBy(?UserInterface $modifiedBy): void;

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface;

    /**
     * @param UserInterface|null $createdBy
     */
    public function setCreatedBy(?UserInterface $createdBy): void;

    /**
     * @return DateTime|null
     */
    public function getModifiedAt(): ?DateTime;

    /**
     * @param DateTime|null $modifiedAt
     */
    public function setModifiedAt(?DateTime $modifiedAt): void;

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime;

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt): void;
}
