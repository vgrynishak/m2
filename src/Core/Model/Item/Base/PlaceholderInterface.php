<?php

namespace App\Core\Model\Item\Base;

interface PlaceholderInterface
{
    public function setPlaceholder(?string $placeholder);

    public function getPlaceholder(): ?string;
}