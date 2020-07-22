<?php

namespace App\Core\Model\ReportForm\Value\File;

use App\Core\Model\ReportForm\Value\BaseValue;

class ValueFile extends BaseValue implements ValueFileInterface
{
    public const VALUE_TYPE = 'file';

    /** @var string */
    private $key;
    /** @var string */
    private $bucket;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @param string $bucket
     */
    public function setBucket(string $bucket): void
    {
        $this->bucket = $bucket;
    }
}
