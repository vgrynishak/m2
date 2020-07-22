<?php

namespace App\App\Query\Item;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\User\UserInterface;

class AllListGroupedByCategoryQuery implements MessageInterface
{
    /** @var UserInterface */
    private $user;

    /** @var bool */
    private $withDevice;

    /**
     * AllListGroupedByCategoryQuery constructor.
     * @param bool $withDevice
     * @param UserInterface $user
     */
    public function __construct(bool $withDevice, UserInterface $user)
    {
        $this->user = $user;
        $this->withDevice = $withDevice;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function withDevice(): bool
    {
        return $this->withDevice;
    }
}
