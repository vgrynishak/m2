<?php

namespace App\Core\Model\Service;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\ModelInterface;
use App\Core\Model\User\UserInterface;
use DateTime;

interface ServiceInterface extends ModelInterface
{
    public function getId(): ServiceId;

    public function getDeviceId(): DeviceId;

    public function getFacility(): FacilityInterface;

    public function getName(): string;

    public function getComment(): string;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): DateTime;

    public function setComment(string $comment): void;

    public function setCreatedAt(DateTime $createdAt): void;

    public function setUpdatedAt(DateTime $updatedAt): void;

    public function getCreatedBy(): ?UserInterface;

    public function setCreatedBy(?UserInterface $createdBy): void;

    public function getModifiedBy(): ?UserInterface;

    public function setModifiedBy(?UserInterface $modifiedBy): void;

}
