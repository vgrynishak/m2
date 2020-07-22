<?php

namespace App\App\Query\Service;

use App\App\Component\Message\MessageInterface;
use App\Core\Model\Service\ServiceId;

class FindByIdQuery implements MessageInterface
{
    /** @var ServiceId  */
    private $id;

    /**
     * FindByIdQuery constructor.
     * @param ServiceId $id
     */
    public function __construct(ServiceId $id)
    {
        $this->id = $id;
    }

    /**
     * @return ServiceId
     */
    public function getId(): ServiceId
    {
        return $this->id;
    }
}
