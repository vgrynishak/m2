<?php

namespace App\Core\Model\ReportTemplate;

class ReportTemplateStatus implements ReportTemplateStatusInterface
{
    public const ARCHIVED = 'archived';
    public const DELETED = 'deleted';
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';

    /** @var string  */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;

    /**
     * ReportTemplateStatus constructor.
     * @param string $id
     * @param string $name
     * @param string $description
     */
    public function __construct(string $id, string $name, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getId(): string
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
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
