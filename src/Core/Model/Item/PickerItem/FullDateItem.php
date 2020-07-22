<?php

namespace App\Core\Model\Item\PickerItem;

use App\Core\Model\Item\Base\BaseItem;

class FullDateItem extends BaseItem implements FullDateItemInterface
{
    /** @var string */
    private $label;
    /** @var string */
    private $NFPA;
    /** @var bool */
    private $remember;
    /** @var bool */
    private $require;
    /** @var string */
    private $placeholder;

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     */
    public function setLabel(?string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getNFPA(): ?string
    {
        return $this->NFPA;
    }

    /**
     * @param string|null $NFPA
     */
    public function setNFPA(?string $NFPA)
    {
        $this->NFPA = $NFPA;
    }

    /**
     * @return bool|null
     */
    public function getRequire(): ?bool
    {
        return $this->require;
    }

    /**
     * @param bool|null $require
     */
    public function setRequire(?bool $require)
    {
        $this->require = $require;
    }

    /**
     * @return bool|null
     */
    public function getRemember(): ?bool
    {
        return  $this->remember;
    }

    /**
     * @param bool|null $remember
     */
    public function setRemember(?bool $remember)
    {
        $this->remember = $remember;
    }

    public function setPlaceholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }
}
