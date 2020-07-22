<?php

namespace App\Infrastructure\Adapter\DTO\Group;

use App\Infrastructure\Adapter\DTO\Device\ShortForGroup as ShortDeviceDto;
use App\Infrastructure\Adapter\DTO\Paragraph\Filter\Full as ShortFilterDto;

class Full
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var ShortFilterDto */
    private $filter;
    /** @var ShortDeviceDto[] */
    private $devices;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function setFilter(ShortFilterDto $filter)
    {
        $this->filter = $filter;
    }

    public function setDevices(array $devices)
    {
        $this->devices = $devices;
    }
}