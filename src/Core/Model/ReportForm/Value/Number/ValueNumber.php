<?php

namespace App\Core\Model\ReportForm\Value\Number;

use App\Core\Model\ReportForm\Value\BaseValue;

class ValueNumber extends BaseValue implements ValueNumberInterface
{
    public const VALUE_TYPE = 'number';

    /** @var integer */
    private $value;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
