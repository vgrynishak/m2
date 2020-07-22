<?php

namespace App\Core\Model\ReportForm\Container;

use App\Core\Model\Exception\InvalidContainerIdException;
use App\Core\Model\Exception\InvalidModelIdException;
use App\Core\Model\ModelId;

class ContainerId extends ModelId
{
    /**
     * ContainerId constructor.
     * @param string $value
     * @throws InvalidContainerIdException
     */
    public function __construct(string $value)
    {
        try {
            parent::__construct($value);
        } catch (InvalidModelIdException $exception) {
            throw new InvalidContainerIdException('Invalid ContainerId given');
        }
    }
}
