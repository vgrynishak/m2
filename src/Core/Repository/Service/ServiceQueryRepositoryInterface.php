<?php

namespace App\Core\Repository\Service;

use App\Core\Model\Service\ServiceId;

interface ServiceQueryRepositoryInterface
{
    public function find(ServiceId $id);
}
