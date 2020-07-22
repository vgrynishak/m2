<?php

namespace App\Core\Model\ReportForm\Value;

interface ValueInterface
{
    public const VALUE_TYPE = 'value_type';

    public function getValueType(): string;
}
