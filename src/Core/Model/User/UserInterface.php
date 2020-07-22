<?php

namespace App\Core\Model\User;

use App\Core\Model\ModelInterface;

interface UserInterface extends ModelInterface
{
    public function getId(): string;

    public function setId(string $id): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function setFirstName(string $firstName): void;

    public function getFirstName(): string;

    public function setLastName(string $lastName): void;

    public function getLastName(): string;
}
