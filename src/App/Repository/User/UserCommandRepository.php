<?php

namespace App\App\Repository\User;

use App\App\Doctrine\Entity\User;
use App\Core\Repository\User\UserCommandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserCommandRepository implements UserCommandRepositoryInterface
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * UserCommandRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function create(User $user) : User
    {
        if (!$user->getEmail()) {
            throw new Exception("Email is required field");
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
