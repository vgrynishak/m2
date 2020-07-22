<?php

namespace App\Core\Repository\Facility;

use App\Core\Model\Facility\FacilityInterface;

interface FacilityCommandRepositoryInterface
{
    public function create(FacilityInterface $facility);
}
