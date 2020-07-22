<?php

namespace App\Core\Model\ReportForm\Value;

abstract class BaseValue implements ValueInterface
{
    public function getValueType(): string
    {
        return static::VALUE_TYPE;
    }
}
