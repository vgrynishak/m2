<?php

namespace App\Core\Model\ReportForm\Value\String;

interface ValueStringInterface
{
    public function getValue(): string;

    public function setValue(string $value): void;
}
