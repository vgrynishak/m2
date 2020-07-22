<?php

namespace App\App\Mapper\User;

use App\App\Doctrine\Entity\User as UserEntity;
use App\Core\Model\User\User;

interface DoctrineEntityUserMapperInterface
{
    public function map(UserEntity $userEntity): User;
}
