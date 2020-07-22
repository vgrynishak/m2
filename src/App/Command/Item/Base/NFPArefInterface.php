<?php

namespace App\App\Command\Item\Base;

interface NFPArefInterface
{
    public function getNFPAref(): ?string;

    public function setNFPAref(?string $NFPAref);
}
