<?php

namespace App\Infrastructure\Adapter\DTO\Section;

class ShortForGetOneReportTemplate
{
    /** @var string */
    private $id;
    /** @var string */
    private $title;
    /** @var int|null */
    private $position;
    /** @var array|null */
    private $paragraphs;

    /**
     * ShortForGetOneReportTemplate constructor.
     * @param string $id
     * @param string $title
     */
    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param array $paragraphs
     */
    public function setParagraphs(array $paragraphs): void
    {
        $this->paragraphs = $paragraphs;
    }
}
