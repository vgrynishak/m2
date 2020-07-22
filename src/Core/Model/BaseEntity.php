<?php

namespace App\Core\Model;

use App\App\Component\UUID\UUID;

abstract class BaseEntity
{
    /** @var UUID */
    private $id;

    /**
     * BaseEntity constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = new UUID();
    }

    /**
     * @return UUID
     */
    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @param UUID $id
     */
    public function setId(UUID $id): void
    {
        $this->id = $id;
    }
}
