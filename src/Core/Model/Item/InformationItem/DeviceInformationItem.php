<?php

namespace App\Core\Model\Item\InformationItem;

use App\Core\Model\Item\Base\BaseItem;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSource;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface;

class DeviceInformationItem extends BaseItem implements DeviceInformationItemInterface
{
    /** @var InfoSource */
    private $infoSource;

    /** @var string */
    private $label;

    /**
     * @param InfoSourceInterface|null $infoSource
     */
    public function setInfoSource(?InfoSourceInterface $infoSource): void
    {
        $this->infoSource = $infoSource;
    }

    public function getInfoSource(): ?InfoSourceInterface
    {
        return $this->infoSource;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}
