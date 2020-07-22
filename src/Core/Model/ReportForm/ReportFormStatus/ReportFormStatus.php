<?php

namespace App\Core\Model\ReportForm\ReportFormStatus;

class ReportFormStatus implements ReportFormStatusInterface
{
    /** @var ReportFormStatusId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $description;

    /**
     * ReportFormStatus constructor.
     * @param ReportFormStatusId $id
     * @param string $name
     */
    public function __construct(ReportFormStatusId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return ReportFormStatusId
     */
    public function getId(): ReportFormStatusId
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
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
