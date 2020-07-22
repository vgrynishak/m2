<?php

namespace App\App\Query\Device;

use App\Core\Model\Device\GroupId;

class FindByChildrenDeviceQuery extends FindByDeviceQuery implements FindByChildrenDeviceQueryInterface
{
    private $groupId;
    /**
     * @param GroupId $groupId
     */
    public function setGroupId(GroupId $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return GroupId
     */
    public function getGroupId(): GroupId
    {
        return $this->groupId;
    }
}
