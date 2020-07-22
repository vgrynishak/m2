<?php

namespace App\Infrastructure\Adapter\DTO\Device;

class ShortForGroup
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var int */
    private $level;

    /**
     * ShortForGroup constructor.
     * @param string $id
     * @param string $name
     * @param int $level
     */
    public function __construct(string $id, string $name, int $level)
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
    }
}