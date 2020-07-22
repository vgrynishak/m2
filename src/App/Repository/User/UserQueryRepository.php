<?php

namespace App\App\Repository\User;

use App\App\Doctrine\Repository\UserRepository;
use App\App\Mapper\User\DoctrineEntityUserMapperInterface;
use App\Core\Model\User\User;
use App\Core\Repository\User\UserQueryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\App\Doctrine\Entity\User as UserEntity;

class UserQueryRepository implements UserQueryRepositoryInterface
{
    /** @var ContainerInterface */
    private $container;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var DoctrineEntityUserMapperInterface */
    private $mapper;

    /**
     * UserQueryRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param DoctrineEntityUserMapperInterface $mapper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ContainerInterface $container,
        DoctrineEntityUserMapperInterface $mapper
    ) {
        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->mapper = $mapper;
    }

    /**
     * @return User|null
     */
    public function getUserFromToken(): ?User
    {
        $tokenUser = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!$tokenUser) {
            return null;
        }

        return $this->find($tokenUser->getId());
    }

    /**
     * @param $id
     * @return User|null
     */
    public function find($id): ?User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository('App:User');
        /** @var UserEntity $userEntity */
        $userEntity = $userRepository->find($id);

        if (!$userEntity instanceof UserEntity) {
            return null;
        }

        return $this->mapper->map($userEntity);
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username) : ?User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository('App:User');
        /** @var UserEntity $userEntity */
        $userEntity = $userRepository->findOneBy(['username' => $username]);

        if (!$userEntity instanceof UserEntity) {
            return null;
        }

        return $this->mapper->map($userEntity);
    }
}
