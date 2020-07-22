<?php

namespace App\Infrastructure\Adapter\DTO\User;

class Full
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
     * Full constructor.
     * @param string $id
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $id, string $email, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}
