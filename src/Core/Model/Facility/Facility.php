<?php

namespace App\Core\Model\Facility;

use DateTime;

class Facility implements FacilityInterface
{
    /** @var FacilityId */
    private $id;

    /** @var string */
    private $name;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;


    /**
     * Facility constructor.
     * @param FacilityId $id
     * @param string $name
     */
    public function __construct(
        FacilityId $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return FacilityId
     */
    public function getId(): FacilityId
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
}
