<?php

namespace App\App\Command\Device;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Device\DeviceId;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\User\UserInterface;
use PhpCollection\CollectionInterface;

interface CreateDeviceCommandInterface extends MessageInterface
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
     * @return DivisionId
     */
    public function getDivisionId(): DivisionId;

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return DeviceId|null
     */
    public function getParentId(): ?DeviceId;

    /**
     * @param DeviceId|null $parentId
     */
    public function setParentId(?DeviceId $parentId): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void;

    /**
     * @param CollectionInterface|null $dynamicFields
     */
    public function setDynamicFields(?CollectionInterface $dynamicFields): void;

    /**
     * @return CollectionInterface|null
     */
    public function getDynamicFields(): ?CollectionInterface;

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
