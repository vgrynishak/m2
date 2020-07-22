<?php

namespace App\Infrastructure\Adapter\DTO\Device;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var int */
    private $level;
    /** @var string */
    private $divisionId;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $updatedAt;
    /** @var string|null */
    private $parentId;
    /** @var string|null */
    private $description;

    /**
     * Full constructor.
     * @param string $id
     * @param string $name
     * @param int $level
     * @param string $divisionId
     * @param int $updatedAt
     * @param int $createdAt
     */
    public function __construct(
        string $id,
        string $name,
        int $level,
        string $divisionId,
        int $updatedAt,
        int $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->divisionId = $divisionId;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @param string|null $parentId
     */
    public function setParentId(?string $parentId): void
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
}
