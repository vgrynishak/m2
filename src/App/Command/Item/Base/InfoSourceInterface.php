<?php

namespace App\App\Command\Item\Base;

use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceId;

interface InfoSourceInterface
{
    public function getInfoSourceId(): InfoSourceId;

    public function setInfoSourceId(InfoSourceId $infoSourceId): void;
}
