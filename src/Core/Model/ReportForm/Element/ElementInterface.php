<?php

namespace App\Core\Model\ReportForm\Element;

use App\Core\Model\Item\ItemId;
use App\Core\Model\ReportForm\Container\ContainerId;
use App\Core\Model\ReportForm\Value\ValueInterface;

interface ElementInterface
{
    public function getId(): ElementId;

    public function getItemId(): ItemId;

    public function getContainerId(): ContainerId;

    public function setFilled(?bool $filled): void;

    public function isFilled(): ?bool;

    public function getValue(): ValueInterface;

    public function setValue(ValueInterface $value): void;
}
