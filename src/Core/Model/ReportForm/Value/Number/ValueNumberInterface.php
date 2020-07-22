<?php

namespace App\Core\Model\ReportForm\Value\Number;

interface ValueNumberInterface
{
    public function getValue(): int;

    public function setValue(int $value): void;
}
