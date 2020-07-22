<?php

namespace App\App\Factory\Value;

use App\Core\Model\ReportForm\Value\File\ValueFile;
use App\Core\Model\ReportForm\Value\File\ValueFileInterface;
use App\Core\Model\ReportForm\Value\Number\ValueNumber;
use App\Core\Model\ReportForm\Value\Number\ValueNumberInterface;
use App\Core\Model\ReportForm\Value\String\ValueString;
use App\Core\Model\ReportForm\Value\String\ValueStringInterface;

class ValueFactory implements ValueFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function makeString(string $value): ValueStringInterface
    {
        $valueString = new ValueString();

        $valueString->setValue($value);

        return $valueString;
    }

    /**
     * @inheritDoc
     */
    public function makeFile(string $key, string $bucket): ValueFileInterface
    {
        $valueFile = new ValueFile();

        $valueFile->setKey($key);
        $valueFile->setBucket($bucket);

        return $valueFile;
    }

    /**
     * @inheritDoc
     */
    public function makeNumber(int $value): ValueNumberInterface
    {
        $valueNumber = new ValueNumber();

        $valueNumber->setValue($value);

        return $valueNumber;
    }
}
