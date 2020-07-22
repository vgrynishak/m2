<?php

namespace App\App\Factory\Group;

use App\Core\Model\Device\GroupInterface;

interface GroupFactoryInterface
{
    public function make(string $id, string $filterId = null): GroupInterface;
}
