<?php

namespace App\App\Command\ServiceInstance;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\User\UserInterface;

class CreateServiceInstanceCommand implements CreateServiceInstanceCommandInterface
{
    /** @var ServiceInstanceId */
    private $id;
    /** @var ServiceId */
    private $serviceId;
    /** @var FacilityId */
    private $facilityId;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateServiceInstanceCommand constructor.
     * @param ServiceInstanceId $id
     * @param ServiceId $serviceId
     * @param FacilityId $facilityId
     * @param UserInterface $createdBy
     */
    public function __construct(
        ServiceInstanceId $id,
        ServiceId $serviceId,
        FacilityId $facilityId,
        UserInterface $createdBy
    ) {
        $this->id = $id;
        $this->serviceId = $serviceId;
        $this->facilityId = $facilityId;
        $this->createdBy = $createdBy;
    }

    /**
     * @return ServiceInstanceId
     */
    public function getId(): ServiceInstanceId
    {
        return $this->id;
    }

    /**
     * @return ServiceId
     */
    public function getServiceId(): ServiceId
    {
        return $this->serviceId;
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
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }
}
