<?php

namespace App\App\Command\Service;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\User\UserInterface;

class CreateServiceCommand implements CreateServiceCommandInterface
{
    /** @var ServiceId */
    private $id;

    /** @var DeviceId  */
    private $deviceId;

    /** @var FacilityId  */
    private $facilityId;

    /** @var string */
    private $name;

    /** @var string */
    private $comment;

    /** @var UserInterface | null */
    private $modifiedBy;

    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateServiceCommand constructor.
     * @param ServiceId $id
     * @param DeviceId $deviceId
     * @param FacilityId $facilityId
     * @param string $name
     */
    public function __construct(
        ServiceId $id,
        DeviceId $deviceId,
        FacilityId $facilityId,
        string $name
    ) {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->facilityId = $facilityId;
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
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId
    {
        return $this->facilityId;
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
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
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

    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
}
