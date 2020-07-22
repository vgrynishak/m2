<?php

namespace App\App\Command\Item\DeviceInformationItem;

use App\App\Command\Item\BaseItemCommand;
use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;

abstract class BaseDeviceInformationItemCommand extends BaseItemCommand
{
    /** @var InfoSourceId */
    private $infoSource;
    /** @var string */
    private $label;

    public function getInfoSourceId(): InfoSourceId
    {
        return $this->infoSource;
    }

    public function setInfoSourceId(InfoSourceId $infoSourceId): void
    {
        $this->infoSource = $infoSourceId;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
