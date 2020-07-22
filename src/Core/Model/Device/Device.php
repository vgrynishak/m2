<?php

namespace App\Core\Model\Device;

use App\Core\Model\Division\DivisionId;
use App\Core\Model\User\UserInterface;
use DateTime;
use PhpCollection\CollectionInterface;

class Device implements DeviceInterface
{
    /** @var DeviceId */
    private $id;
    /** @var string */
    private $name;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $updatedAt;
    /** @var DeviceId | null */
    private $parentId;
    /** @var int */
    private $level;
    /** @var DivisionId */
    private $divisionId;
    /** @var string | null */
    private $description;
    /** @var string */
    private $alias;
    /** @var CollectionInterface | null */
    private $children;
    /** @var CollectionInterface | null */
    private $dynamicFields;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface | null */
    private $createdBy;

    /**
     * Device constructor.
     * @param DeviceId $id
     * @param string $name
     * @param int $level
     * @param DivisionId $divisionId
     * @param string $alias
     */
    public function __construct(
        DeviceId $id,
        string $name,
        int $level,
        DivisionId $divisionId,
        string $alias
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->divisionId = $divisionId;
        $this->alias = $alias;
    }

    /**
     * @return DeviceId
     */
    public function getId(): DeviceId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return DeviceId|null
     */
    public function getParentId(): ?DeviceId
    {
        return $this->parentId;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return DivisionId
     */
    public function getDivisionId(): DivisionId
    {
        return $this->divisionId;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * @param DeviceId|null $parentId
     */
    public function setParentId(?DeviceId $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getChildren(): ?CollectionInterface
    {
        return $this->children;
    }

    /**
     * @param CollectionInterface|null $paragraphs
     */
    public function setChildren(?CollectionInterface $paragraphs): void
    {
        $this->children = $paragraphs;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return CollectionInterface|null
     */
    public function getDynamicFields(): ?CollectionInterface
    {
        return $this->dynamicFields;
    }

    /**
     * @param CollectionInterface|null $dynamicFields
     */
    public function setDynamicFields(?CollectionInterface $dynamicFields): void
    {
        $this->dynamicFields = $dynamicFields;
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
}
