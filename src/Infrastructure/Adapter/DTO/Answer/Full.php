<?php

namespace App\Infrastructure\Adapter\DTO\Answer;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $itemId;
    /** @var string */
    private $assessment;
    /** @var string */
    private $value;
    /** @var int */
    private $position;

    public function __construct(
        string $id,
        string $itemId,
        string $assessment
    ) {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->assessment = $assessment;
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position)
    {
        $this->position = $position;
    }
}
