<?php

namespace App\App\Command\Item\PickerItem;

use App\App\Command\Item\BaseItemCommand;

abstract class BasePickerItemCommand extends BaseItemCommand
{
    /** @var string */
    private $label;
    /** @var string */
    private $placeholder;
    /** @var string */
    private $NFPAref;
    /** @var string */
    private $remembered;
    /** @var string */
    private $required;

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param bool|null $remembered
     */
    public function setRemembered(?bool $remembered)
    {
        $this->remembered = $remembered;
    }

    /**
     * @return bool|null
     */
    public function getRemembered(): ?bool
    {
        return $this->remembered;
    }

    /**
     * @param bool|null $required
     */
    public function setRequired(?bool $required)
    {
        $this->required = $required;
    }

    /**
     * @return bool|null
     */
    public function getRequired(): ?bool
    {
        return $this->required;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param string|null $placeholder
     */
    public function setPlaceholder(?string $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * @return string|null
     */
    public function getNFPAref(): ?string
    {
        return $this->NFPAref;
    }

    /**
     * @param string|null $NFPAref
     */
    public function setNFPAref(?string $NFPAref)
    {
        $this->NFPAref = $NFPAref;
    }
}
