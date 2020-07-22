<?php

namespace App\Core\Model\ReportForm\Value\File;

interface ValueFileInterface
{
    public function getKey(): string;

    public function getBucket(): string;

    public function setKey(string $key): void;

    public function setBucket(string $bucket): void;
}
