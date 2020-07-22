<?php

namespace App\Core\Model\ServiceInstance;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\ModelInterface;
use App\Core\Model\Service\ServiceInterface;
use App\Core\Model\User\UserInterface;
use DateTime;

interface ServiceInstanceInterface extends ModelInterface
{
    /**
     * @return ServiceInstanceId
     */
    public function getId(): ServiceInstanceId;

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;

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
