<?php

namespace App\App\Mapper\Device;

use App\App\Doctrine\Entity\Group as GroupORM;
use App\Core\Model\Device\Group;
use App\Core\Model\Device\GroupId;
use App\Core\Model\Device\GroupInterface;
use \App\Core\Model\Exception\InvalidGroupIdException;

class GroupEntityMapper implements GroupEntityMapperInterface
{
    /**
     * @param GroupORM $groupORM
     * @return GroupInterface
     * @throws InvalidGroupIdException
     */
    public function map(GroupORM $groupORM): GroupInterface
    {
        if (!$groupORM instanceof GroupORM) {
            return null;
        }

        return new Group(
            new GroupId($groupORM->getId()),
            $groupORM->getName()
        );
    }
}
