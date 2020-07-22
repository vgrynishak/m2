<?php

namespace App\Core\Model\ReportForm\Container;

use App\Core\Model\DeviceInstance\DeviceInstanceId;
use App\Core\Model\Paragraph\ParagraphId;
use App\Core\Model\ReportForm\Screen\ScreenId;
use PhpCollection\CollectionInterface;
use DateTime;

interface ContainerInterface
{
    public function getId(): ContainerId;

    public function getParagraphId(): ParagraphId;

    public function getScreenId(): ScreenId;

    public function setTitle(?string $title): void;

    public function getTitle(): string;

    public function setPosition(?int $position): void;

    public function getPosition(): ?int;

    public function setLevel(?int $level): void;

    public function getLevel(): ?int;

    public function setDeviceInstanceId(?DeviceInstanceId $deviceInstanceId): void;

    public function getDeviceInstanceId(): ?DeviceInstanceId;

    public function setParent(?ContainerId $parent): void;

    public function getParent(): ?ContainerId;

    public function setChildren(?CollectionInterface $children): void;

    public function getChildren(): ?CollectionInterface;

    public function setElements(?CollectionInterface $elements): void;

    public function getElements(): ?CollectionInterface;

    public function setCreatedAt(DateTime $createdAt): void;

    public function getModifiedAt(): DateTime;

    public function setModifiedAt(DateTime $modifiedAt): void;
}
