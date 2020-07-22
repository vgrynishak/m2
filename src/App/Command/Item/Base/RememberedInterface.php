<?php

namespace App\App\Command\Item\Base;

interface RememberedInterface
{
    public function setRemembered(?bool $remembered);

    public function getRemembered(): ?bool;
}
