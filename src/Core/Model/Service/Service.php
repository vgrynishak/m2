<?php

namespace App\Core\Model\Service;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityInterface;
use App\Core\Model\User\UserInterface;
use DateTime;

class Service implements ServiceInterface
{
    /** @var ServiceId */
    private $id;

    /** @var DeviceId  */
    private $deviceId;

    /** @var FacilityInterface */
    private $facility;

    /** @var string */
    private $name;

    /** @var string */
    private $comment;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;

    /** @var UserInterface|null */
    private $createdBy;

    /** @var UserInterface|null */
    private $modifiedBy;

    /**
     * Service constructor.
     * @param ServiceId $id
     * @param DeviceId $deviceId
     * @param FacilityInterface $facility
     * @param string $name
     */
    public function __construct(
        ServiceId $id,
        DeviceId $deviceId,
        FacilityInterface $facility,
        string $name
    ) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->facility = $facility;
        $this->name = $name;
    }

    /**
     * @return ServiceId
     */
    public function getId(): ServiceId
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
     * @return FacilityInterface
     */
    public function getFacility(): FacilityInterface
    {
        return $this->facility;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
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
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
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
}
