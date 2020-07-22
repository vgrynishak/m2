<?php

namespace App\App\Command\DeviceInstance;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\User\UserInterface;

interface CreateDeviceInstanceCommandInterface extends MessageInterface
{
    /**
     * @return DeviceInstanceId
     */
    public function getId(): DeviceInstanceId;

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId;

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
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface;
}
