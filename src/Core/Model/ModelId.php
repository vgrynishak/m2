<?php

namespace App\Core\Model;

use App\Core\Model\Exception\InvalidModelIdException;
use Ramsey\Uuid\Uuid as UuidGenerator;

abstract class ModelId implements ModelIdInterface
{
    private $value;

    /**
     * ModelId constructor.
     * @param string $value
     *
     * @throws InvalidModelIdException
     */
    public function __construct(string $value)
    {
        if (!UuidGenerator::isValid($value)) {
            throw new InvalidModelIdException();
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
