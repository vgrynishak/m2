<?php

namespace App\App\Command\ServiceInstance;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Service\ServiceId;
use App\Core\Model\ServiceInstance\ServiceInstanceId;
use App\Core\Model\User\UserInterface;

interface CreateServiceInstanceCommandInterface extends MessageInterface
{
    /**
     * @return ServiceInstanceId
     */
    public function getId(): ServiceInstanceId;

    /**
     * @return ServiceId
     */
    public function getServiceId(): ServiceId;

    /**
     * @return FacilityId
     */
    public function getFacilityId(): FacilityId;

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
