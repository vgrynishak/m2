<?php

namespace App\Infrastructure\Adapter\DTO\ReportTemplate;

class Short
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var int */
    private $updatedAt;

    /** @var string */
    private $modifiedBy;

    /** @var string */
    private $status;

    public function __construct(
        string $id,
        string $name,
        int $updatedAt,
        string $modifiedBy,
        string $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->updatedAt = $updatedAt;
        $this->modifiedBy = $modifiedBy;
        $this->status = $status;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
