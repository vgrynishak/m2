<?php

namespace App\Core\Model\Item\Base;

interface RememberInterface
{
    public function setRemember(?bool $remember);

    public function getRemember(): ?bool;
}