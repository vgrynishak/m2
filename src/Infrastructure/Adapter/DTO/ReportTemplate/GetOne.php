<?php

namespace App\Infrastructure\Adapter\DTO\ReportTemplate;

use App\Infrastructure\Adapter\DTO\Section\Full as SectionFullDTO;

class GetOne
{
    /** @var string  */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $serviceName;
    /** @var string */
    private $status;
    /** @var string|null  */
    private $description = null;
    /** @var SectionFullDTO[]|null */
    private $sections;

    /**
     * GetOne constructor.
     * @param string $id
     * @param string $name
     * @param string $serviceName
     */
    public function __construct(
        string $id,
        string $name,
        string $serviceName,
        string $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->serviceName = $serviceName;
        $this->status = $status;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param array|null $sections
     */
    public function setSections(?array $sections): void
    {
        $this->sections = $sections;
    }
}
