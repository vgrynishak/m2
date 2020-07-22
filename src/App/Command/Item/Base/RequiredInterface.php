<?php

namespace App\App\Command\Item\Base;

interface RequiredInterface
{
    public function setRequired(?bool $required);

    public function getRequired(): ?bool;
}
