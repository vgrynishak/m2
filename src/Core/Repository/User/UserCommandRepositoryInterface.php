<?php

namespace App\Core\Repository\User;

use App\App\Doctrine\Entity\User;

interface UserCommandRepositoryInterface
{
    public function create(User $model);
}
