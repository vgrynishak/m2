<?php

namespace App\Infrastructure\Adapter\User;

use App\Core\Model\User\UserInterface;
use App\Infrastructure\Adapter\DTO\User\Full as FullUserDTO;

class Full
{
    /**
     * @param UserInterface $user
     * @return FullUserDTO
     */
    public static function adapt(UserInterface $user): FullUserDTO
    {
        $fullUser = new FullUserDTO(
            $user->getId(),
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName()
        );

        return $fullUser;
    }
}
