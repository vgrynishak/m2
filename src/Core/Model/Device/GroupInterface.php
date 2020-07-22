<?php

namespace App\Core\Model\Device;

use App\Core\Model\ModelInterface;
use App\Core\Model\Paragraph\ParagraphFilterInterface;
use PhpCollection\CollectionInterface;

interface GroupInterface extends ModelInterface
{
    public function getId(): GroupId;

    public function getName(): string;

    public function getDevices(): ?CollectionInterface;

    public function setDevices(?CollectionInterface $devices): void;

    public function getFilter(): ?ParagraphFilterInterface;

    public function setFilter(?ParagraphFilterInterface $filter): void;
}