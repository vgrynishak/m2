<?php

namespace App\Core\Repository\Facility;

use App\Core\Model\Facility\FacilityId;
use App\Core\Model\Facility\FacilityInterface;

interface FacilityQueryRepositoryInterface
{
    public function find(FacilityId $id): ?FacilityInterface;
}
