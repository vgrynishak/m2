<?php

namespace App\Core\Model\Item\Base;

interface NFPAInterface
{
    public function setNFPA(?string $NFPA);

    public function getNFPA(): ?string;
}
