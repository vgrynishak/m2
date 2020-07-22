<?php

namespace App\Core\Repository\Division;

use App\Core\Model\Division\DivisionId;

interface DivisionQueryRepositoryInterface
{
    public function find(DivisionId $id);
}
