<?php

namespace App\App\Handler\User;

use App\Core\Repository\User\UserCommandRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\App\Command\User\CreateUserCommand as CreateUserCommand;
use App\App\Doctrine\Entity\User;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUserCommandHandler implements MessageHandlerInterface
{
    /** @var UserCommandRepositoryInterface */
    protected $userRepository;
    /** @var ManagerRegistry */
    protected $registry;

    /**
     * CreateUserCommandHandler constructor.
     *
     * @param UserCommandRepositoryInterface $userRepository
     * @param ManagerRegistry $registry
     */
    public function __construct(UserCommandRepositoryInterface $userRepository, ManagerRegistry $registry)
    {
        $this->userRepository = $userRepository;
        $this->registry = $registry;
    }

    /**
     * @param CreateUserCommand $message
     *
     * @return mixed
     */
    public function __invoke(CreateUserCommand $message)
    {
        /** @var User $user */
        $user = new User();

        $user->setEnabled($message->getEnable());
        $user->setUsername($message->getUsername());
        $user->setPassword($message->getPassword());
        $user->setRoles($message->getRoles());
        $user->setEmail($message->getEmail());
        $user->setFirstName($message->getFirstName());
        $user->setLastName($message->getLastName());

        try {
            return $this->userRepository->create($user);
        } catch (\Exception $exception) {
            $this->registry->resetManager();
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), 0, $exception);
        }
    }
}
