<?php

namespace App\App\Component\UUID;

use Ramsey\Uuid\Uuid as UuidGenerator;

class UUID
{
    private $value;

    /**
     * @param string|null $value
     *
     * @throws \Exception
     */
    public function __construct(?string $value = null)
    {
        if (null === $value) {
            $uuid = UuidGenerator::uuid4();
            $value = $uuid->toString();
        } elseif (!$this->validate($value)) {
            throw new \InvalidArgumentException();
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

    /**
     * @param UUID $id
     *
     * @return bool
     */
    public function isEqual(UUID $id)
    {
        return $this->value === $id->value;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validate(string $value): bool
    {
        $pattern = "/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/";

        return preg_match($pattern, $value);
    }
}
