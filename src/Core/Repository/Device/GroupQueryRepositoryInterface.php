<?php

namespace App\Core\Repository\Device;

use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;

interface GroupQueryRepositoryInterface
{
    public function find(GroupId $id): ?GroupInterface;
}
