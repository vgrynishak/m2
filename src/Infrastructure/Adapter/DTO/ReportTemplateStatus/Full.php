<?php

namespace App\Infrastructure\Adapter\DTO\ReportTemplateStatus;

class Full
{
    /** @var string  */
    private $id;
    /** @var string */
    private $name;
    /** @var string|null */
    private $description;

    /**
     * Full constructor.
     * @param string $id
     * @param string $name
     * @param string|null $description
     */
    public function __construct(string $id, string $name, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
}
