<?php

namespace App\Infrastructure\Adapter\DTO\Paragraph;

use App\Infrastructure\Adapter\DTO\Device\ShortForGetOneReportTemplate as ShortDeviceDTO;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as FullParagraphFilterDTO;

class ShortForGetOneReportTemplate
{
    /** @var string */
    private $id;
    /** @var string | null */
    private $headerValue;
    /** @var int | null */
    private $position;
    /** @var int */
    private $level = 1;
    /** @var string | null */
    private $parentId;
    /** @var array | null */
    private $items;
    /** @var array | null */
    private $children;
    /** @var ShortDeviceDTO | null */
    private $device;
    /** @var FullParagraphFilterDTO | null */
    private $filter;

    /**
     * ShortForGetOneReportTemplate constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string|null $headerValue
     */
    public function setHeaderValue(?string $headerValue): void
    {
        $this->headerValue = $headerValue;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param array|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param ShortDeviceDTO|null $device
     */
    public function setDevice(?ShortDeviceDTO $device): void
    {
        $this->device = $device;
    }

    /**
     * @param string|null $parentId
     */
    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    /**
     * @param FullParagraphFilterDTO|null $filter
     */
    public function setFilter(?FullParagraphFilterDTO $filter): void
    {
        $this->filter = $filter;
    }
}
