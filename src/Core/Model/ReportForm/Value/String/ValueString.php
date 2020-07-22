<?php

namespace App\Core\Model\ReportForm\Value\String;

use App\Core\Model\ReportForm\Value\BaseValue;

class ValueString extends BaseValue implements ValueStringInterface
{
    public const VALUE_TYPE = 'string';

    /** @var string */
    private $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
