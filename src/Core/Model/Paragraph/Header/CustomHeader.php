<?php

namespace App\Core\Model\Paragraph\Header;

class CustomHeader implements CustomHeaderInterface
{
    /** @var string */
    private $value;

    /**
     * CustomHeader constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
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
