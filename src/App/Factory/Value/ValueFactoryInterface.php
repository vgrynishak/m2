<?php

namespace App\App\Factory\Value;

use App\Core\Model\ReportForm\Value\File\ValueFileInterface;
use App\Core\Model\ReportForm\Value\Number\ValueNumberInterface;
use App\Core\Model\ReportForm\Value\String\ValueStringInterface;

interface ValueFactoryInterface
{
    /**
     * @param string $value
     * @return ValueStringInterface
     */
    public function makeString(string $value): ValueStringInterface;

    /**
     * @param string $key
     * @param string $bucket
     * @return ValueFileInterface
     */
    public function makeFile(string $key, string $bucket): ValueFileInterface;

    /**
     * @param int $value
     * @return ValueNumberInterface
     */
    public function makeNumber(int $value): ValueNumberInterface;
}
