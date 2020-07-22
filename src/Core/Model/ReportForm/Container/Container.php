<?php

namespace App\Core\Model\ReportForm\Container;

use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\ReportForm\Screen\ScreenId;
use DateTime;
use PhpCollection\CollectionInterface;

class Container implements ContainerInterface
{
    /** @var ContainerId */
    private $id;
    /** @var ParagraphId */
    private $paragraphId;
    /** @var ScreenId */
    private $screenId;
    /** @var string */
    private $title;
    /** @var int */
    private $position;
    /** @var int */
    private $level;
    /** @var DeviceInstanceId */
    private $deviceInstanceId;
    /** @var ContainerId */
    private $parent;
    /** @var CollectionInterface */
    private $children;
    /** @var CollectionInterface */
    private $elements;
    /** @var DateTime */
    private $createdAt;
    /** @var DateTime */
    private $modifiedAt;

    /**
     * Container constructor.
     * @param ContainerId $id
     * @param ParagraphId $paragraphId
     * @param ScreenId $screenId
     */
    public function __construct(
        ContainerId $id,
        ParagraphId $paragraphId,
        ScreenId $screenId
    ) {
        $this->id = $id;
        $this->paragraphId = $paragraphId;
        $this->screenId = $screenId;
    }

    public function getId(): ContainerId
    {
        return $this->id;
    }

    public function getParagraphId(): ParagraphId
    {
        return $this->paragraphId;
    }

    public function getScreenId(): ScreenId
    {
        return $this->screenId;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setLevel(?int $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setDeviceInstanceId(?DeviceInstanceId $deviceInstanceId): void
    {
        $this->deviceInstanceId = $deviceInstanceId;
    }

    public function getDeviceInstanceId(): ?DeviceInstanceId
    {
        return $this->deviceInstanceId;
    }

    public function setParent(?ContainerId $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?ContainerId
    {
        return $this->parent;
    }

    public function setChildren(?CollectionInterface $children): void
    {
        $this->children = $children;
    }

    public function getChildren(): ?CollectionInterface
    {
        return $this->children;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getModifiedAt(): DateTime
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    public function setElements(?CollectionInterface $elements): void
    {
        $this->elements = $elements;
    }

    public function getElements(): ?CollectionInterface
    {
        return $this->elements;
    }
}
