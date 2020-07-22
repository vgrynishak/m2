<?php

namespace App\Core\Model\Item\Base;

interface LabelInterface
{
    public function setLabel(?string $label);

    public function getLabel(): ?string;
}