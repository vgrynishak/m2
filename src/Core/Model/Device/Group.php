<?php

namespace App\Core\Model\Device;

use App\Core\Model\Paragraph\ParagraphFilterInterface;
use PhpCollection\CollectionInterface;

class Group implements GroupInterface
{
    const GROUP_RELATED_TO_INSPECTED_DEVICE = 'related_to_inspected_device';
    const GROUP_EVERY_ON_SITE_DEVICE = 'every_on_site_device';

    /** @var GroupId */
    private $id;
    /** @var string */
    private $name;
    /** @var CollectionInterface */
    private $devices;
    /** @var ParagraphFilterInterface */
    private $filter;

    /**
     * Group constructor.
     * @param GroupId $id
     * @param string $name
     */
    public function __construct(
        GroupId $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return GroupId
     */
    public function getId(): GroupId
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
     * @return CollectionInterface|null
     */
    public function getDevices(): ?CollectionInterface
    {
        return $this->devices;
    }

    /**
     * @param CollectionInterface|null $devices
     */
    public function setDevices(?CollectionInterface $devices): void
    {
        $this->devices = $devices;
    }

    /**
     * @return ParagraphFilterInterface|null
     */
    public function getFilter(): ?ParagraphFilterInterface
    {
        return $this->filter;
    }

    /**
     * @param ParagraphFilterInterface|null $filter
     */
    public function setFilter(?ParagraphFilterInterface $filter): void
    {
        $this->filter = $filter;
    }
}
