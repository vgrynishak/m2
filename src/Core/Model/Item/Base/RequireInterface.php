<?php


namespace App\Core\Model\Item\Base;


interface RequireInterface
{
    public function setRequire(?bool $require);

    public function getRequire(): ?bool;
}