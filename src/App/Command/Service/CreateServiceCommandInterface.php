<?php

namespace App\App\Command\Service;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\UserInterface;

interface CreateServiceCommandInterface extends MessageInterface
{
    /**
     * @return ServiceId
     */
    public function getId(): ServiceId;

    /**
     * @return DeviceId
     */
    public function getDeviceId(): DeviceId;

    /**
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void;

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

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void;
}
