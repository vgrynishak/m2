<?php

namespace App\App\Command\Item\Base;

interface PlaceholderInterface
{
    public function getPlaceholder(): ?string;

    public function setPlaceholder(?string $placeholder);
}
