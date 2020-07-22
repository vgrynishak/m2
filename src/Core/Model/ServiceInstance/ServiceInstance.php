<?php

namespace App\Core\Model\ServiceInstance;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use DateTime;

class ServiceInstance implements ServiceInstanceInterface
{
    /** @var ServiceInstanceId */
    private $id;
    /** @var ServiceInterface */
    private $service;
    /** @var FacilityId */
    private $facilityId;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface | null */
    private $createdBy;
    /** @var DateTime | null */
    private $modifiedAt;
    /** @var DateTime | null */
    private $createdAt;

    /**
     * ServiceInstance constructor.
     * @param ServiceInstanceId $id
     * @param ServiceInterface $service
     * @param FacilityId $facilityId
     */
    public function __construct(ServiceInstanceId $id, ServiceInterface $service, FacilityId $facilityId)
    {
        $this->id = $id;
        $this->service = $service;
        $this->facilityId = $facilityId;
    }

    /**
     * @return ServiceInstanceId
     */
    public function getId(): ServiceInstanceId
    {
        return $this->id;
    }

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface
    {
        return $this->service;
    }

    /**
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId
    {
        return $this->facilityId;
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
