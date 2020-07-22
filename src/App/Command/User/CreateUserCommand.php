<?php

namespace App\App\Command\User;

class CreateUserCommand
{
    /** @var string */
    private $username;
    /** @var string */
    private $email;
    /** @var string  */
    private $password;
    /** @var array  */
    private $roles;
    /** @var string  */
    private $enable;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;

    /**
     * CreateUserCommand constructor.
     * @param string $username
     * @param string $email
     * @param string $password
     * @param array $roles
     * @param string $enable
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(
        string $username,
        string $email,
        string $password,
        array $roles,
        string $enable,
        string $firstName,
        string $lastName
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->enable = $enable;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
