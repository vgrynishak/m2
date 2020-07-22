<?php

namespace App\Tests\Behat\Context\User;

use App\App\Handler\User\CreateUserCommandHandler;
use App\App\Command\User\CreateUserCommand;
use App\App\Doctrine\Entity\User;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;

class CreateCommand implements Context
{
    /** @var CreateUserCommandHandler */
    private $createUserCommandHandler;
    /** @var Connection */
    private $doctrineConnection;

    /** @var CreateUserCommand */
    private $createUserCommand;
    /** @var User */
    private $user;

    /**
     * UserCommandHandler constructor.
     *
     * @param CreateUserCommandHandler $createUserCommandHandler
     * @param Connection $connection
     */
    public function __construct(CreateUserCommandHandler $createUserCommandHandler, Connection $connection)
    {
        $this->createUserCommandHandler = $createUserCommandHandler;
        $this->doctrineConnection = $connection;
    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @param $enable
     * @param $roles
     *
     * @Given User param username :arg1 and password :arg2 and email :arg3 and enable :arg4 and roles :arg5 and name :arg6 and last name :arg7
     */
    public function userParamUsernameAndPasswordAndEmailAndEnableAndRoles($username, $password, $email, $enable, $roles, $firstName, $lastName)
    {
        $this->createUserCommand = new CreateUserCommand($username, $email, $password, [$roles], $enable, $firstName, $lastName);
    }

    /**
     * @When I call create user command handler
     *
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function iCallCreateUserCommandHandler()
    {
        /** @var CreateUserCommandHandler $handler */
        $handler = $this->createUserCommandHandler;

        $this->doctrineConnection->beginTransaction();
        $this->user = $handler($this->createUserCommand);
        $this->doctrineConnection->rollBack();
    }

    /**
     * @Then I should have created User entity
     */
    public function iShouldHaveCreatedUserEntity()
    {
        if (!$this->user instanceof User) {
            return false;
        }

        return true;
    }
}
