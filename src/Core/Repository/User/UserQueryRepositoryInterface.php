<?php

namespace App\Core\Repository\User;

use App\Core\Model\User\User;

interface UserQueryRepositoryInterface
{
    public function getUserFromToken(): ?User;

    public function find($id): ?User;

    public function findByUsername(string $username): ?User;

}
