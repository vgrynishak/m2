<?php

namespace App\App\Command\Item\Base;

interface LabelInterface
{
    public function setLabel(string $label);

    public function getLabel(): string;
}
