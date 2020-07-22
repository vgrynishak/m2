<?php

namespace App\App\Mapper\Device;

use App\App\Doctrine\Entity\Group as GroupORM;
use App\Core\Model\Device\GroupInterface;

interface GroupEntityMapperInterface
{
    public function map(GroupORM $groupORM) :GroupInterface;
}
