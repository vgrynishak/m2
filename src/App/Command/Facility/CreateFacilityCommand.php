<?php

namespace App\App\Command\Facility;

use App\Components\Message\MessageInterface;

class CreateFacilityCommand implements MessageInterface
{
    /** @var string */
    private $name;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    public function __construct(
        string $name,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ) {
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
