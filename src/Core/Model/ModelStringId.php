<?php

namespace App\Core\Model;

use App\Core\Model\Exception\InvalidModelIdException;

abstract class ModelStringId implements ModelIdInterface
{
    /** @var string */
    private $value;

    /**
     * ModelStringId constructor.
     * @param string $value
     * @throws InvalidModelIdException
     */
    public function __construct(string $value)
    {
        if (trim(strlen($value)) >= 100) {
            throw new InvalidModelIdException('Value lenght must be less than or equal to 100');
        }

        if (trim(strlen($value)) <= 3) {
            throw new InvalidModelIdException('Value lenght must be greater than or equal to 3');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
