<?php

namespace App\Infrastructure\Adapter\DTO\Service;

class Full
{
    /** @var string */
    private $id;
    /** @var string  */
    private $deviceId;
    /** @var string */
    private $name;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $updatedAt;
    /** @var string|null */
    private $comment;
    /** @var string|null */
    private $facilityId;

    /**
     * Full constructor.
     * @param string $id
     * @param string $deviceId
     * @param string $name
     * @param int $createdAt
     * @param int $updatedAt
     */
    public function __construct(string $id, string $deviceId, string $name, int $createdAt, int $updatedAt)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @param string|null $facilityId
     */
    public function setFacilityId(?string $facilityId): void
    {
        $this->facilityId = $facilityId;
    }
}