<?php

namespace App\App\Command\Device;

use App\Core\Model\Device\DeviceId;
use App\Core\Model\Division\DivisionId;
use App\Core\Model\User\UserInterface;
use PhpCollection\CollectionInterface;

class CreateDeviceCommand implements CreateDeviceCommandInterface
{
    /** @var DeviceId  */
    private $id;
    /** @var string */
    private $name;
    /** @var DivisionId */
    private $divisionId;
    /** @var DeviceId|null  */
    private $parentId;
    /** @var int  */
    private $level;
    /** @var string|null  */
    private $description;
    /** @var string */
    private $alias;
    /** @var CollectionInterface | null */
    private $dynamicFields;
    /** @var UserInterface | null */
    private $modifiedBy;
    /** @var UserInterface */
    private $createdBy;

    /**
     * CreateDeviceCommand constructor.
     * @param DeviceId $id
     * @param string $name
     * @param DivisionId $divisionId
     * @param int $level
     * @param string $alias
     * @param UserInterface $createdBy
     */
    public function __construct(
        DeviceId $id,
        string $name,
        DivisionId $divisionId,
        int $level,
        string $alias,
        UserInterface $createdBy
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->divisionId = $divisionId;
        $this->level = $level;
        $this->alias = $alias;
        $this->createdBy = $createdBy;
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
     * @return DeviceId|null
     */
    public function getParentId(): ?DeviceId
    {
        return $this->parentId;
    }

    /**
     * @return DivisionId
     */
    public function getDivisionId(): DivisionId
    {
        return $this->divisionId;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param DeviceId|null $parentId
     */
    public function setParentId(?DeviceId $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }
}
