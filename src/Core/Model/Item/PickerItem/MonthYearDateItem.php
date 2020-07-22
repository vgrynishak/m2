<?php

namespace App\Core\Model\Item\PickerItem;

use App\Core\Model\Item\Base\BaseItem;

class MonthYearDateItem extends BaseItem implements MonthYearDateItemInterface
{
    /** @var string */
    private $label;
    /** @var string */
    private $NFPA;
    /** @var string */
    private $placeholder;
    /** @var bool */
    private $remember;
    /** @var bool */
    private $require;

    public function setLabel(?string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setNFPA(?string $NFPA)
    {
        $this->NFPA = $NFPA;
    }

    public function getNFPA(): ?string
    {
        return $this->NFPA;
    }

    public function setPlaceholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setRemember(?bool $remember)
    {
        $this->remember = $remember;
    }

    public function getRemember(): ?bool
    {
        return $this->remember;
    }

    public function setRequire(?bool $require)
    {
        $this->require = $require;
    }

    public function getRequire(): ?bool
    {
        return $this->require;
    }
}