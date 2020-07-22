<?php

namespace App\Core\Model\Device;

use App\Core\Model\Division\DivisionId;
use App\Core\Model\ModelInterface;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

interface DeviceInterface extends ModelInterface
{
    /**
     * @return DeviceId
     */
    public function getId(): DeviceId;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime;

    /**
     * @return DeviceId|null
     */
    public function getParentId(): ?DeviceId;

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return DivisionId
     */
    public function getDivisionId(): DivisionId;

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void;

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void;

    /**
     * @param DeviceId|null $parentId
     */
    public function setParentId(?DeviceId $parentId): void;

    /**
     * @return CollectionInterface|null
     */
    public function getChildren(): ?CollectionInterface;

    /**
     * @param CollectionInterface|null $paragraphs
     */
    public function setChildren(?CollectionInterface $paragraphs): void;

    /**
     * @return CollectionInterface|null
     */
    public function getDynamicFields(): ?CollectionInterface;

    /**
     * @param CollectionInterface|null $dynamicFields
     */
    public function setDynamicFields(?CollectionInterface $dynamicFields): void;

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
}
