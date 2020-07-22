<?php

namespace App\Core\Model\Item\Base;

use App\Core\Model\Item\InformationItem\InfoSource\InfoSourceInterface as InfoSource;

interface InfoSourceInterface
{
    public function setInfoSource(?InfoSource $infoSource);

    public function getInfoSource(): ?InfoSource;
}
