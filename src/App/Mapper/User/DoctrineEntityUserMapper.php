<?php

namespace App\App\Mapper\User;

use App\Core\Model\User\User;
use App\App\Doctrine\Entity\User as UserEntity;

class DoctrineEntityUserMapper implements DoctrineEntityUserMapperInterface
{
    /**
     * @param UserEntity $userEntity
     * @return User
     */
    public function map(UserEntity $userEntity): User
    {
        return new User($userEntity);
    }
}
