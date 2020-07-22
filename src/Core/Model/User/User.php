<?php

namespace App\Core\Model\User;

use FOS\UserBundle\Model\UserInterface as FOSUserInterface;

class User implements UserInterface
{
    /** @var string */
    private $id;
    /** @var string */
    private $email;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;

    /**
     * User constructor.
     * @param FOSUserInterface|null $user
     */
    public function __construct(?FOSUserInterface $user)
    {
        if ($user) {
            $this->id = $user->getId();
            $this->email = $user->getEmail();
            $this->firstName = $user->getFirstName();
            $this->lastName = $user->getLastName();
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
