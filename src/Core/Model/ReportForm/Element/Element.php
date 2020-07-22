<?php

namespace App\Core\Model\ReportForm\Element;

use App\Core\Model\Item\ItemId;
use App\Core\Model\ReportForm\Container\ContainerId;
use App\Core\Model\ReportForm\Value\ValueInterface;

class Element implements ElementInterface
{
    /** @var ElementId */
    private $id;
    /** @var ItemId */
    private $itemId;
    /** @var ContainerId */
    private $containerId;
    /** @var bool */
    private $filled;
    /** @var ValueInterface */
    private $value;

    /**
     * Element constructor.
     * @param ElementId $id
     * @param ItemId $itemId
     * @param ContainerId $containerId
     */
    public function __construct(
        ElementId $id,
        ItemId $itemId,
        ContainerId $containerId
    ) {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->containerId = $containerId;
    }

    /**
     * @return ElementId
     */
    public function getId(): ElementId
    {
        return $this->id;
    }

    /**
     * @return ItemId
     */
    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    /**
     * @return ContainerId
     */
    public function getContainerId(): ContainerId
    {
        return $this->containerId;
    }

    /**
     * @param bool|null $filled
     */
    public function setFilled(?bool $filled): void
    {
        $this->filled = $filled;
    }

    /**
     * @return bool|null
     */
    public function isFilled(): ?bool
    {
        return $this->filled;
    }

    /**
     * @return ValueInterface
     */
    public function getValue(): ValueInterface
    {
        return $this->value;
    }

    /**
     * @param ValueInterface $value
     */
    public function setValue(ValueInterface $value): void
    {
        $this->value = $value;
    }
}
