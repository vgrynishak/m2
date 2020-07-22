<?php

namespace App\Core\Model\Item\PictureItem;

use App\Core\Model\Item\Base\BaseItem;

class SignatureItem extends BaseItem implements SignatureItemInterface
{
    /** @var string */
    private $label;
    /** @var string */
    private $NFPA;
    /** @var bool */
    private $require;

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
}